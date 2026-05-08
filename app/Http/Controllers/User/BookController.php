<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Book::count() < 3, 404);

        $storageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;
        $search = $request->string('q')->toString();

        $books = Book::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString()
            ->through(function ($book) use ($storageUrl) {
                $images = collect($book->images)
                    ->map(fn ($image) => $storageUrl($image))
                    ->filter()
                    ->values();

                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'slug' => $book->slug,
                    'publisher' => $book->publisher,
                    'author' => $book->author,
                    'category' => $book->category,
                    'subject' => $book->subject,
                    'isbn' => $book->isbn,
                    'dimensions' => $book->dimensions,
                    'pages' => $book->pages,
                    'year' => $book->year,
                    'price' => $book->price,
                    'excerpt' => Str::limit(strip_tags($book->description), 140),
                    'image' => $images->first(),
                ];
            });

        return inertia('User/Book/Index', [
            'books' => $books,
            'filters' => [
                'q' => $search,
            ],
        ]);
    }

    public function __invoke(Book $book)
    {
        $storageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;

        $images = collect($book->images)
            ->map(fn ($image) => $storageUrl($image))
            ->filter()
            ->values();

        return inertia('User/Book/Show', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'slug' => $book->slug,
                'publisher' => $book->publisher,
                'author' => $book->author,
                'category' => $book->category,
                'subject' => $book->subject,
                'isbn' => $book->isbn,
                'dimensions' => $book->dimensions,
                'pages' => $book->pages,
                'year' => $book->year,
                'price' => $book->price,
                'description' => $book->description,
                'image' => $images->first(),
                'images' => $images,
                'created_at' => $book->created_at?->format('d M Y'),
                'updated_at' => $book->updated_at?->format('d M Y'),
            ],
        ]);
    }
}
