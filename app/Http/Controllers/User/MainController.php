<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Book;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Advantage;
use App\Models\Faq;
use App\Models\HeroSection;
use App\Models\ManuscriptCategory;
use App\Models\ProcessStep;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function __invoke(Request $request)
    {
        $storageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;
        $showWhenMinimum = fn ($items, int $minimum) => $items->count() >= $minimum
            ? $items->values()
            : collect();
        $showEvenWhenMinimum = function ($items, int $minimum) {
            $count = $items->count();

            if ($count < $minimum) {
                return collect();
            }

            if ($count % 2 !== 0) {
                $count--;
            }

            return $count >= $minimum
                ? $items->take($count)->values()
                : collect();
        };

        $heroSection = HeroSection::latest('updated_at')->first();

        $heroSection = $heroSection ? [
            'heading' => $heroSection->heading,
            'subheading' => $heroSection->subheading,
            'image' => $storageUrl($heroSection->image),
        ] : null;

        $blogs = Blog::where('status', 'published')
            ->latest()
            ->limit(6)
            ->get()
            ->map(fn ($blog) => [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'image' => $storageUrl($blog->image),
                'excerpt' => Str::limit(strip_tags($blog->content), 150),
                'views' => $blog->views,
                'created_at' => $blog->created_at->format('d M Y'),
            ]);

        $blogs = $showWhenMinimum($blogs, 3);

        $processSteps = ProcessStep::orderBy('position')
            ->get()
            ->map(fn ($step) => [
                'id' => $step->position,
                'title' => $step->title,
                'copy' => $step->description,
            ]);

        $books = Book::latest()
            ->limit(6)
            ->get()
            ->map(function ($book) use ($storageUrl) {
                $images = collect($book->images)
                    ->map(fn ($image) => $storageUrl($image))
                    ->filter()
                    ->values();
                $cover = $images->first();

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
                    'description' => Str::of(strip_tags($book->description))->squish()->toString(),
                    'excerpt' => Str::limit(strip_tags($book->description), 150),
                    'image' => $cover,
                    'images' => $images,
                ];
            });

        $books = $showWhenMinimum($books, 3);

        $services = Service::with('packages')
            ->where('is_active', true)
            ->oldest()
            ->get()
            ->map(fn ($service) => [
                'id' => $service->id,
                'name' => $service->name,
                'slug' => $service->slug,
                'short_description' => $service->short_description,
                'description' => $service->description ? Str::limit(strip_tags($service->description), 150) : null,
                'starting_price' => $service->starting_price,
                'sections' => $service->sections ?? [],
                'image' => $storageUrl($service->image),
                'packages' => $service->packages->map(fn ($package) => [
                    'id' => $package->id,
                    'name' => $package->name,
                    'price' => $package->price,
                    'features' => $package->features ?? [],
                    'recommendation' => $package->recommendation,
                    'badge_color' => $package->badge_color,
                ])->values(),
            ]);

        $services = $showWhenMinimum($services, 3);

        $faqs = Faq::where('status', 'published')
            ->oldest()
            ->get()
            ->map(fn ($faq) => [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ]);

        $faqs = $showWhenMinimum($faqs, 4);

        $testimonials = Testimonial::latest()
            ->get()
            ->map(fn ($testimonial) => [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'title' => $testimonial->title,
                'position' => $testimonial->title,
                'image' => $storageUrl($testimonial->image),
                'testimonial' => $testimonial->testimonial,
                'message' => $testimonial->testimonial,
                'rating' => $testimonial->rating,
            ]);

        $testimonials = $showWhenMinimum($testimonials, 3);

        $advantages = Advantage::oldest()
            ->get()
            ->map(fn ($advantage) => [
                'id' => $advantage->id,
                'title' => $advantage->title,
                'description' => $advantage->description,
                'image' => $storageUrl($advantage->image),
            ]);

        $advantages = $showEvenWhenMinimum($advantages, 2);

        $manuscriptCategories = ManuscriptCategory::oldest()
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'title' => $category->title,
                'description' => $category->description,
                'image' => $storageUrl($category->image),
                'requirements' => $category->requirements ?? [],
                'attachments' => $category->attachments ?? [],
                'submission_method' => $category->submission_method ?? [],
                'attached_documents' => collect($category->attached_documents ?? [])
                    ->filter(fn ($document) => ! empty($document['path']))
                    ->map(fn ($document) => [
                        'name' => $document['name'] ?? basename($document['path']),
                        'path' => $document['path'],
                        'url' => asset('storage/' . $document['path']),
                        'size' => $document['size'] ?? null,
                        'extension' => $document['extension'] ?? pathinfo($document['path'], PATHINFO_EXTENSION),
                    ])
                    ->values(),
                'document_count' => count($category->attached_documents ?? []),
            ]);

        $manuscriptCategories = $showWhenMinimum($manuscriptCategories, 2);

        abort_if(collect([
            $blogs,
            $books,
            $services,
            $faqs,
            $testimonials,
            $advantages,
            $manuscriptCategories,
        ])->contains(fn ($items) => $items->isEmpty()), 404);

        return inertia('User/Index', [
            'hero_section' => $heroSection,
            'blogs' => $blogs,
            'process_steps' => $processSteps,
            'books' => $books,
            'services' => $services,
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'advantages' => $advantages,
            'manuscript_categories' => $manuscriptCategories,
        ]);
    }
}
