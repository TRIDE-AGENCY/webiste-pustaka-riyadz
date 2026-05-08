<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('packages')->when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request()->q . '%')
                    ->orWhere('short_description', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $services->through(function ($service) {
            $service->image_url = $service->image
                ? asset('storage/' . $service->image)
                : null;
            $service->image_name = $service->image
                ? basename($service->image)
                : null;
            $service->image_size = $service->image && Storage::disk('public')->exists($service->image)
                ? Storage::disk('public')->size($service->image)
                : 0;

            return $service;
        });

        $services->appends(['q' => request()->q]);

        return inertia('Admin/Service/Index', [
            'services' => $services,
        ]);
    }

    public function create()
    {
        $api_tinymce_key = Setting::value('api_tinymce_key');

        return inertia('Admin/Service/Create', [
            'api_tinymce_key' => $api_tinymce_key,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $pathImage = $request->file('image')->store('services', 'public');

        $service = Service::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            // Beri fallback null/[] jika kosong agar aman
            'sections' => $request->sections ? json_decode($request->sections, true) : null, 
            'image' => $pathImage,
        ]);

        // Gunakan $request->boolean() agar aman dari string "false" / "0" bawaan FormData
        if ($request->boolean('has_packages') && $request->packages) {
            $packages = json_decode($request->packages, true);
            foreach ($packages as $pkg) {
                $service->packages()->create([
                    'name' => $pkg['name'],
                    'price' => $pkg['price'],
                    'features' => $pkg['features'], 
                    'recommendation' => $pkg['recommendation'] ?? null,
                    'badge_color' => $pkg['badge_color'] ?? 'primary',
                ]);
            }
        }

        return redirect()->route('admin.services.index');
    }
    
    public function edit(Service $service)
    {
        $api_tinymce_key = Setting::value('api_tinymce_key');

        $service->load('packages');

        $service->image_url = $service->image
            ? asset('storage/' . $service->image)
            : null;
        $service->image_name = $service->image
            ? basename($service->image)
            : null;
        $service->image_size = $service->image && Storage::disk('public')->exists($service->image)
            ? Storage::disk('public')->size($service->image)
            : 0;

        return inertia('Admin/Service/Edit', [
            'service' => $service,
            'api_tinymce_key' => $api_tinymce_key,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate($this->rules($service), $this->messages());

        $pathImage = $service->image;

        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }
            $pathImage = $request->file('image')->store('services', 'public');
        }

        $this->cleanupEditorImages($request->description, $service->description);

        $service->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'sections' => $request->sections ? json_decode($request->sections, true) : null,
            'image' => $pathImage,
        ]);

        $service->packages()->delete();
        
        if ($request->boolean('has_packages') && $request->packages) {
            $packages = json_decode($request->packages, true);
            foreach ($packages as $pkg) {
                $service->packages()->create([
                    'name' => $pkg['name'],
                    'price' => $pkg['price'],
                    'features' => $pkg['features'],
                    'recommendation' => $pkg['recommendation'] ?? null,
                    'badge_color' => $pkg['badge_color'] ?? 'primary',
                ]);
            }
        }

        return redirect()->route('admin.services.index');
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $this->cleanupEditorImages('', $service->description);

        $service->delete();

        return redirect()->route('admin.services.index');
    }

    public function uploadImageEditor(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('editor', 'public');
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 500);
    }

    private function cleanupEditorImages($newContent, $oldContent = '')
    {
        preg_match_all('/editor\/([^\s"\'\?<>#]+)/', $oldContent, $oldMatches);
        $oldImages = $oldMatches[1] ?? [];

        if (empty($oldImages)) {
            return;
        }

        foreach ($oldImages as $imageName) {
            if (!str_contains($newContent, $imageName)) {
                $path = 'editor/' . $imageName;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }

    private function rules(?Service $service = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'starting_price' => ['nullable', 'string', 'max:255'],
            'has_packages' => ['required', 'boolean'],
            'packages' => ['nullable', 'json'],
            'sections' => ['nullable', 'json'],
            'image' => [$service ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Nama layanan tidak boleh kosong.',
            'short_description.required' => 'Deskripsi singkat tidak boleh kosong.',
            'image.required' => 'Gambar layanan wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
        ];
    }
}
