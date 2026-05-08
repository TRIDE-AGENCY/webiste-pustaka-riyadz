<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroSection = HeroSection::latest('updated_at')->first();

        if ($heroSection) {
            $heroSection->image_url = $heroSection->image
                ? asset('storage/' . $heroSection->image)
                : null;
            $heroSection->image_name = $heroSection->image
                ? basename($heroSection->image)
                : null;
            $heroSection->image_size = $heroSection->image && Storage::disk('public')->exists($heroSection->image)
                ? Storage::disk('public')->size($heroSection->image)
                : 0;
        }

        return inertia('Admin/HeroSection/Index', [
            'hero_section' => $heroSection,
        ]);
    }

    public function update(Request $request)
    {
        $heroSection = HeroSection::latest('updated_at')->first();

        $request->validate($this->rules($heroSection), $this->messages());

        $pathImage = $heroSection?->image;

        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }

            $pathImage = $request->file('image')->store('hero-sections', 'public');
        }

        if ($heroSection) {
            $heroSection->update([
                'heading' => $request->heading,
                'subheading' => $request->subheading,
                'image' => $pathImage,
            ]);
        } else {
            HeroSection::create([
                'heading' => $request->heading,
                'subheading' => $request->subheading,
                'image' => $pathImage,
            ]);
        }

        return redirect()->route('admin.hero_sections.index');
    }

    private function rules(?HeroSection $heroSection = null): array
    {
        return [
            'heading' => ['required', 'string', 'max:255'],
            'subheading' => ['required', 'string'],
            'image' => [$heroSection ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    private function messages(): array
    {
        return [
            'heading.required' => 'Heading tidak boleh kosong.',
            'subheading.required' => 'Subheading tidak boleh kosong.',
            'image.required' => 'Gambar hero wajib diunggah.',
            'image.image' => 'Gambar hero harus berupa file gambar.',
            'image.mimes' => 'Gambar hero harus berekstensi jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar hero maksimal 10MB.',
        ];
    }
}
