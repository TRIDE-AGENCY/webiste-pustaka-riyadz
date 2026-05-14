<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogAdController extends Controller
{
    public function index()
    {
        $blogAds = BlogAd::when(request()->q, function ($query) {
            $search = request()->q;

            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%')
                    ->orWhere('link', 'like', '%' . $search . '%');
            });
        })->latest()->paginate(10);

        $blogAds->through(function ($blogAd) {
            $blogAd->image_url = $blogAd->image
                ? asset('storage/' . $blogAd->image)
                : null;
            $blogAd->image_name = $blogAd->image
                ? basename($blogAd->image)
                : null;
            $blogAd->image_size = $blogAd->image && Storage::disk('public')->exists($blogAd->image)
                ? Storage::disk('public')->size($blogAd->image)
                : 0;

            return $blogAd;
        });

        $blogAds->appends(['q' => request()->q]);

        return inertia('Admin/BlogAd/Index', [
            'blog_ads' => $blogAds,
        ]);
    }

    public function store(Request $request)
    {
        $this->normalizeLinkInput($request);
        $request->validate($this->rules(), $this->messages());

        $pathImage = $request->file('image')->store('blog-ads', 'public');

        BlogAd::create([
            'image' => $pathImage,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.blog_ads.index');
    }

    public function update(Request $request, BlogAd $blogAd)
    {
        $this->normalizeLinkInput($request);
        $request->validate($this->rules($blogAd), $this->messages());

        $pathImage = $blogAd->image;

        if ($request->hasFile('image')) {
            if ($pathImage && Storage::disk('public')->exists($pathImage)) {
                Storage::disk('public')->delete($pathImage);
            }

            $pathImage = $request->file('image')->store('blog-ads', 'public');
        }

        $blogAd->update([
            'image' => $pathImage,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.blog_ads.index');
    }

    public function destroy(BlogAd $blogAd)
    {
        if ($blogAd->image && Storage::disk('public')->exists($blogAd->image)) {
            Storage::disk('public')->delete($blogAd->image);
        }

        $blogAd->delete();

        return redirect()->route('admin.blog_ads.index');
    }

    private function rules(?BlogAd $blogAd = null): array
    {
        return [
            'image' => [
                $blogAd ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if ($value && ! $this->hasAllowedImageRatio($value)) {
                        $fail('Rasio gambar iklan blog harus 4:3 atau 1:1.');
                    }
                },
            ],
            'description' => ['required', 'string', 'max:255'],
            'link' => [
                'nullable',
                'string',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if (! $value) {
                        return;
                    }

                    $scheme = strtolower((string) parse_url($value, PHP_URL_SCHEME));

                    if (! filter_var($value, FILTER_VALIDATE_URL) || ! in_array($scheme, ['http', 'https'], true)) {
                        $fail('Link iklan blog harus berupa URL valid dengan awalan http:// atau https://.');
                    }
                },
            ],
        ];
    }

    private function messages(): array
    {
        return [
            'image.required' => 'Gambar tidak boleh kosong.',
            'image.image' => 'Gambar iklan blog harus berupa file gambar.',
            'image.mimes' => 'Gambar iklan blog harus berekstensi jpg, jpeg, png, atau webp.',
            'image.max' => 'Ukuran gambar iklan blog maksimal 10MB.',
            'description.required' => 'Keterangan tidak boleh kosong.',
            'description.max' => 'Keterangan maksimal 255 karakter.',
            'link.max' => 'Link iklan blog maksimal 2048 karakter.',
        ];
    }

    private function normalizeLinkInput(Request $request): void
    {
        $link = trim((string) $request->input('link', ''));

        $request->merge([
            'link' => $link === '' ? null : $link,
        ]);
    }

    private function hasAllowedImageRatio($image): bool
    {
        $size = @getimagesize($image->getPathname());

        if (! $size || empty($size[0]) || empty($size[1])) {
            return false;
        }

        $ratio = $size[0] / $size[1];

        return collect([4 / 3, 1])->contains(function ($allowedRatio) use ($ratio) {
            return abs($ratio - $allowedRatio) <= 0.02;
        });
    }
}
