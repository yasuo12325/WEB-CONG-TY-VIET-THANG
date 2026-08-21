<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'founded_year' => Setting::get('founded_year', '2003'),
            'employee_count' => Setting::get('employee_count'),
            'partner_count' => Setting::get('partner_count'),
        ];

        $categories = Category::query()
            ->active()
            ->topLevel()
            ->orderBy('sort_order')
            ->get();

        // "Lĩnh vực hoạt động" panels use a real product photo as their
        // background image (never stock/fabricated art) — same lookup as
        // the products ecosystem landing page.
        foreach ($categories as $category) {
            $category->coverProduct = Product::published()
                ->where('category_id', $category->id)
                ->with(['images' => fn ($q) => $q->where('is_primary', true)])
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->first();
        }

        $featuredProducts = Product::query()
            ->published()
            ->where('is_featured', true)
            ->with(['images' => fn ($q) => $q->where('is_primary', true)])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $partners = Partner::active()->get();

        $latestNews = News::query()
            ->published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('home', [
            'stats' => $stats,
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'partners' => $partners,
            'latestNews' => $latestNews,
            'hero' => [
                'headline' => Setting::getTrans('hero_headline'),
                'subheadline' => Setting::getTrans('hero_subheadline'),
            ],
            'aboutSummary' => Setting::getTrans('about_summary'),
        ]);
    }
}
