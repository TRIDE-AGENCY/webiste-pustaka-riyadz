<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvantageController extends Controller
{
    public function index()
    {
        $advantages = Advantage::when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request()->q . '%')
                    ->orWhere('description', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $advantages->through(function ($advantage) {
            $advantage->image_url = $advantage->image
                ? asset('storage/' . $advantage->image)
                : null;
            $advantage->image_name = $advantage->image
                ? basename($advantage->image)
                : null;
            $advantage->image_size = $advantage->image && Storage::disk('public')->exists($advantage->image)
                ? Storage::disk('public')->size($advantage->image)
                : 0;

            return $advantage;
        });

        $advantages->appends(['q' => request()->q]);

        return inertia('Admin/Advantage/Index', [
            'advantages' => $advantages,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $pathImage = $request->file('image')->store('advantages', 'public');

        Advantage::create([
            'image' => $pathImage,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.advantages.index');
    }

    public function update(Request $request, Advantage $advantage)
    {
        $request->validate($this->rules($advantage), $this->messages());

        $pathImage = $advantage->image;

        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }

            $pathImage = $request->file('image')->store('advantages', 'public');
        }

        $advantage->update([
            'image' => $pathImage,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.advantages.index');
    }

    public function destroy(Advantage $advantage)
    {
        if ($advantage->image && Storage::disk('public')->exists($advantage->image)) {
            Storage::disk('public')->delete($advantage->image);
        }

        $advantage->delete();

        return redirect()->route('admin.advantages.index');
    }

    private function rules(?Advantage $advantage = null): array
    {
        return [
            'image' => [$advantage ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'image.required' => 'Gambar tidak boleh kosong.',
            'image.image' => 'Gambar keunggulan harus berupa file gambar.',
            'image.mimes' => 'Gambar keunggulan harus berekstensi jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar keunggulan maksimal 10MB.',
            'title.required' => 'Judul tidak boleh kosong.',
            'description.required' => 'Deskripsi tidak boleh kosong.',
        ];
    }
}
