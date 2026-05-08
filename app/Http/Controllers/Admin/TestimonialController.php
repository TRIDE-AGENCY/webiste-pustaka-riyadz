<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request()->q . '%')
                    ->orWhere('title', 'like', '%' . request()->q . '%')
                    ->orWhere('testimonial', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $testimonials->through(function ($testimonial) {
            $testimonial->image_url = $testimonial->image
                ? asset('storage/' . $testimonial->image)
                : null;
            $testimonial->image_name = $testimonial->image
                ? basename($testimonial->image)
                : null;
            $testimonial->image_size = $testimonial->image && Storage::disk('public')->exists($testimonial->image)
                ? Storage::disk('public')->size($testimonial->image)
                : 0;

            return $testimonial;
        });

        $testimonials->appends(['q' => request()->q]);

        return inertia('Admin/Testimonial/Index', [
            'testimonials' => $testimonials,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules(), $this->messages());

        $pathImage = $request->file('image')->store('testimonials', 'public');

        Testimonial::create([
            'name' => $request->name,
            'title' => $request->title,
            'rating' => $request->rating,
            'image' => $pathImage,
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('admin.testimonials.index');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate($this->rules($testimonial), $this->messages());

        $pathImage = $testimonial->image;

        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }

            $pathImage = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update([
            'name' => $request->name,
            'title' => $request->title,
            'rating' => $request->rating,
            'image' => $pathImage,
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('admin.testimonials.index');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index');
    }

    private function rules(?Testimonial $testimonial = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'image' => [$testimonial ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'testimonial' => ['required', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong.',
            'title.required' => 'Jabatan tidak boleh kosong.',
            'rating.required' => 'Rating tidak boleh kosong.',
            'rating.integer' => 'Rating harus berupa angka bulat.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'image.required' => 'Gambar tidak boleh kosong.',
            'image.image' => 'Gambar testimoni harus berupa file gambar.',
            'image.mimes' => 'Gambar testimoni harus berekstensi jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar testimoni maksimal 10MB.',
            'testimonial.required' => 'Testimoni tidak boleh kosong.',
        ];
    }
}
