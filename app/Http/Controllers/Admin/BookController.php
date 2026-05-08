<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::when(request()->q, function ($query) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request()->q . '%')
                    ->orWhere('author', 'like', '%' . request()->q . '%')
                    ->orWhere('publisher', 'like', '%' . request()->q . '%')
                    ->orWhere('category', 'like', '%' . request()->q . '%')
                    ->orWhere('subject', 'like', '%' . request()->q . '%')
                    ->orWhere('isbn', 'like', '%' . request()->q . '%')
                    ->orWhere('description', 'like', '%' . request()->q . '%');
            });
        })->latest()->paginate(10);

        $books->through(function ($book) {
            $book->cover = collect($book->images)->first();

            return $book;
        });

        $books->appends(['q' => request()->q]);

        return inertia('Admin/Book/Index', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        $api_tinymce_key = Setting::value('api_tinymce_key');

        return inertia('Admin/Book/Create', [
            'api_tinymce_key' => $api_tinymce_key,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $imagePaths = $this->storeImages($request);

        Book::create([
            ...$validated,
            'slug' => $this->generateUniqueSlug($request->title),
            'images' => $imagePaths,
        ]);

        return redirect()->route('admin.books.index');
    }

    public function edit(Book $book)
    {
        $book->existing_images = collect($book->images)->map(function ($image) {
            return [
                'path' => $image,
                'name' => basename($image),
                'size' => Storage::disk('public')->exists($image)
                    ? Storage::disk('public')->size($image)
                    : 0,
                'url' => asset('storage/' . $image),
            ];
        })->values();

        return inertia('Admin/Book/Edit', [
            'book' => $book,
            'api_tinymce_key' => Setting::value('api_tinymce_key'),
        ]);
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate($this->rules($book), $this->messages());

        $removedImages = collect($request->input('removed_images', []))
            ->filter()
            ->values()
            ->all();

        $existingImages = collect($book->images)
            ->reject(fn ($image) => in_array($image, $removedImages))
            ->values();

        $newImages = collect($this->storeImages($request));
        $finalImages = $existingImages->merge($newImages)->values()->all();

        if (count($finalImages) === 0) {
            return back()->withErrors([
                'images' => 'Minimal satu gambar buku wajib tersedia.',
            ])->withInput();
        }

        foreach ($removedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $book->update([
            ...$validated,
            'slug' => $this->generateUniqueSlug($request->title, $book->id),
            'images' => $finalImages,
        ]);

        return redirect()->route('admin.books.index');
    }

    public function destroy(Book $book)
    {
        foreach ($book->images ?? [] as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }

        $book->delete();

        return redirect()->route('admin.books.index');
    }

    private function rules(?Book $book = null): array
    {
        $bookId = $book?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:255', Rule::unique('books', 'isbn')->ignore($bookId)],
            'dimensions' => ['required', 'string', 'max:255'],
            'pages' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'images' => [$book ? 'nullable' : 'required', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'removed_images' => ['nullable', 'array'],
            'removed_images.*' => ['string'],
        ];
    }

    private function messages(): array
    {
        return [
            'isbn.unique' => 'ISBN sudah digunakan. Gunakan ISBN lain.',
            'description.required' => 'Deskripsi tidak boleh kosong.',
            'images.required' => 'Gambar buku tidak boleh kosong.',
            'images.array' => 'Format gambar buku tidak valid.',
            'images.*.image' => 'Setiap file gambar buku harus berupa file gambar.',
            'images.*.mimes' => 'Gambar buku harus berekstensi jpg, jpeg, png, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar buku maksimal 10MB.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
        ];
    }

    private function storeImages(Request $request): array
    {
        if (! $request->hasFile('images')) {
            return [];
        }

        return collect($request->file('images'))
            ->map(fn ($image) => $image->store('books', 'public'))
            ->values()
            ->all();
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Book::when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
