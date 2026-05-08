<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advantage;
use App\Models\Blog;
use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ManuscriptCategory;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $userCount = User::count();
        $blogCount = Blog::count();
        $bookCount = Book::count();
        $faqCount = Faq::count();
        $testimonialCount = Testimonial::count();
        $advantageCount = Advantage::count();
        $manuscriptCategoryCount = ManuscriptCategory::count();
        $serviceCount = Service::count();

        $publishedContentCount = Blog::where('status', 'published')->count()
            + Faq::where('status', 'published')->count();

        // $manuscriptDocumentCount = ManuscriptCategory::get()
        //     ->sum(fn ($category) => count($category->attached_documents ?? []));

        $contentDistribution = [
            'labels' => ['Pengguna', 'Blog', 'FAQ', 'Buku', 'Testimoni', 'Keunggulan', 'Layanan', 'Kategori Naskah'],
            'data' => [
                $userCount,
                $blogCount,
                $faqCount,
                $bookCount,
                $testimonialCount,
                $advantageCount,
                $serviceCount,
                $manuscriptCategoryCount,
            ],
        ];

        $statusOverview = [
            'labels' => ['Blog', 'FAQ'],
            'datasets' => [
                [
                    'label' => 'Terbit',
                    'data' => [
                        Blog::where('status', 'published')->count(),
                        Faq::where('status', 'published')->count(),
                    ],
                ],
                [
                    'label' => 'Arsip',
                    'data' => [
                        Blog::where('status', 'archived')->count(),
                        Faq::where('status', 'archived')->count(),
                    ],
                ],
            ],
        ];

        $monthlyActivity = $this->buildMonthlyActivity([
            User::class,
            Blog::class,
            Book::class,
            Faq::class,
            Testimonial::class,
            Advantage::class,
            Service::class,
            ManuscriptCategory::class,
        ]);

        return inertia('Admin/Dashboard/Index', [
            'dashboard' => [
                'cards' => [
                    // [
                    //     'label' => 'Total Pengguna',
                    //     'value' => $userCount,
                    //     'icon' => 'ri-user-fill',
                    //     'caption' => 'Pengguna terdaftar dalam sistem',
                    // ],
                    [
                        'label' => 'Konten Terbit',
                        'value' => $publishedContentCount,
                        'icon' => 'ri-article-fill',
                        'caption' => 'Blog dan FAQ yang sedang aktif',
                    ],
                    [
                        'label' => 'Total Buku',
                        'value' => $bookCount,
                        'icon' => 'ri-book-open-fill',
                        'caption' => 'Koleksi buku yang sudah dimasukkan',
                    ],
                    [
                        'label' => 'Total Testimoni',
                        'value' => $testimonialCount,
                        'icon' => 'ri-chat-quote-fill',
                        'caption' => 'Ulasan dan kepercayaan pengguna',
                    ],
                    [
                        'label' => 'Total Layanan',
                        'value' => $serviceCount,
                        'icon' => 'ri-briefcase-fill',
                        'caption' => 'Layanan yang ditawarkan',
                    ],
                    // [
                    //     'label' => 'Dokumen Naskah',
                    //     'value' => $manuscriptDocumentCount,
                    //     'icon' => 'ri-file-list-3-fill',
                    //     'caption' => 'Dokumen terlampir pada kategori naskah',
                    // ],
                ],
                'charts' => [
                    'content_distribution' => $contentDistribution,
                    'status_overview' => $statusOverview,
                    'monthly_activity' => $monthlyActivity,
                ],
            ],
        ]);
    }

    private function buildMonthlyActivity(array $models): array
    {
        $start = now()->startOfMonth()->subMonths(11);
        $period = CarbonPeriod::create($start, '1 month', now()->startOfMonth());

        $labels = collect($period)
            ->map(fn (Carbon $date) => $date->translatedFormat('M Y'))
            ->values();

        $monthKeys = collect($period)
            ->map(fn (Carbon $date) => $date->format('Y-m'))
            ->values();

        $totalsByMonth = $monthKeys
            ->mapWithKeys(fn ($month) => [$month => 0]);

        foreach ($models as $model) {
            $model::query()
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key, COUNT(*) as total")
                ->where('created_at', '>=', $start)
                ->groupBy('month_key')
                ->pluck('total', 'month_key')
                ->each(function ($total, $monthKey) use (&$totalsByMonth) {
                    if (isset($totalsByMonth[$monthKey])) {
                        $totalsByMonth[$monthKey] += (int) $total;
                    }
                });
        }

        return [
            'labels' => $labels,
            'data' => $monthKeys->map(fn ($month) => $totalsByMonth[$month] ?? 0)->values(),
        ];
    }
}
