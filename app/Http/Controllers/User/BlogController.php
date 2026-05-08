<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Blog::where('status', 'published')->count() < 3, 404);

        $storageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;
        $search = $request->string('q')->toString();

        $blogs = Blog::query()
            ->where('status', 'published')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString()
            ->through(function ($blog) use ($storageUrl) {
                $plainContent = Str::of(strip_tags($blog->content))->squish()->toString();

                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'slug' => $blog->slug,
                    'image' => $storageUrl($blog->image),
                    'excerpt' => Str::limit($plainContent, 180),
                    'views' => $blog->views,
                    'created_at' => $blog->created_at?->format('d M Y'),
                ];
            });

        return inertia('User/Blog/Index', [
            'blogs' => $blogs,
            'filters' => [
                'q' => $search,
            ],
        ]);
    }

    public function show(Blog $blog)
    {
        abort_if($blog->status !== 'published', 404);

        $storageUrl = fn (?string $path) => $path ? asset('storage/' . $path) : null;
        DB::table('blogs')->where('id', $blog->id)->increment('views');
        $blog->views = ((int) $blog->views) + 1;

        $plainContent = Str::of(strip_tags($blog->content))->squish()->toString();

        $relatedBlogs = Blog::query()
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($relatedBlog) use ($storageUrl) {
                $plainContent = Str::of(strip_tags($relatedBlog->content))->squish()->toString();

                return [
                    'id' => $relatedBlog->id,
                    'title' => $relatedBlog->title,
                    'slug' => $relatedBlog->slug,
                    'image' => $storageUrl($relatedBlog->image),
                    'excerpt' => Str::limit($plainContent, 100),
                    'created_at' => $relatedBlog->created_at?->toIso8601String(),
                ];
            })
            ->values();

        $sessionKey = 'viewed_blog_' . $blog->id;
        if (!session()->has($sessionKey)) {
            $blog->increment('views');
            session()->put($sessionKey, true);
        }

        $description = Str::limit(strip_tags($blog->content), 150);
        $setting = Setting::first();
        
        return inertia('User/Blog/Show', [
            'setting'     => $setting,
            'blog' => [
                'id' => $blog->id,
                'title' => $blog->title,
                'slug' => $blog->slug,
                'image' => $storageUrl($blog->image),
                'content' => $blog->content,
                'excerpt' => Str::limit($plainContent, 170),
                'views' => $blog->views,
                'created_at' => $blog->created_at?->toIso8601String(),
                'updated_at' => $blog->updated_at?->toIso8601String(),
            ],
            'description' => $description,
            'current_url' => url()->current(),
            'app_url'     => rtrim($setting->site_url, '/'),
            'related_blogs' => $relatedBlogs,
        ])->withViewData([
            'meta_title'       => $blog->title . ' − ' . $setting->site_title,
            'meta_description' => $description,
            'meta_image'       => asset('storage/' . $blog->image),
            'meta_url'         => url()->current(),
        ]);
    }
}
