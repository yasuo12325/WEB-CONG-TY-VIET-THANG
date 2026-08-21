<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->published()
            ->with(['category', 'images' => fn ($q) => $q->where('is_primary', true)]);

        if ($request->filled('category')) {
            $category = Category::where('slug', $request->string('category'))->first();

            if ($category) {
                $categoryIds = [$category->id, ...$category->children()->pluck('id')];
                $query->whereIn('category_id', $categoryIds);
            }
        }

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('sort_order')->paginate(12)->withQueryString();

        $categories = Category::active()->topLevel()
            ->withCount(['products' => fn ($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $request->string('category')->toString(),
            'searchTerm' => $request->string('q')->toString(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless(
            $product->status === Product::STATUS_PUBLISHED
                && (! $product->published_at || $product->published_at->lte(now())),
            404
        );

        $product->load(['category', 'images', 'documents', 'specs']);

        $relatedProducts = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->where('is_primary', true)])
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
