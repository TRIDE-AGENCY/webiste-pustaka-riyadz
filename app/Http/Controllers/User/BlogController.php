<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogAd;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Blog::where('status', 'published')->count() < 3, 404);

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
            ->withQueryString();

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

        $blog->load('author');

        $setting = Setting::first();

        $relatedBlogs = Blog::query()
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        $sessionKey = 'viewed_blog_' . $blog->id;
        if (!session()->has($sessionKey)) {
            $blog->increment('views');
            session()->put($sessionKey, true);
        }

        $description = Str::limit(strip_tags($blog->content), 150);
        $blogAd = BlogAd::query()->inRandomOrder()->first();

        return inertia('User/Blog/Show', [
            'setting'     => $setting,
            'blog' => $blog,
            'description' => $description,
            'current_url' => url()->current(),
            'app_url'     => rtrim($setting->site_url, '/'),
            'related_blogs' => $relatedBlogs,
            'blog_ad' => $blogAd,
        ])->withViewData([
            'meta_title'       => $blog->title . ' − ' . $setting->site_title,
            'meta_description' => $description,
            'meta_image'       => asset('storage/' . $blog->image),
            'meta_url'         => url()->current(),
        ]);
    }

}
