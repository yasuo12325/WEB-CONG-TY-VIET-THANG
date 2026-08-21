<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * /san-pham
     *
     * Three presentations sharing one route, matching how a visitor actually
     * arrives here:
     *  - no category, no search  -> the category "ecosystem" (this is the
     *    new default landing view — see products.ecosystem)
     *  - a category is selected  -> that category's own hero + product grid
     *    (products.category), optionally narrowed by a search term
     *  - a search term only      -> a flat cross-category results view
     *    (products.search)
     */
    public function index(Request $request)
    {
        $activeCategorySlug = $request->string('category')->toString();
        $searchTerm = $request->string('q')->toString();

        $categories = Category::active()->topLevel()
            ->withCount(['products' => fn ($q) => $q->published()])
            ->orderBy('sort_order')
            ->get();

        $activeCategory = filled($activeCategorySlug)
            ? ($categories->firstWhere('slug', $activeCategorySlug) ?? Category::where('slug', $activeCategorySlug)->first())
            : null;

        // Falls back to the ecosystem view for both "/san-pham" itself and a
        // stale/invalid ?category= slug — never a confusing "search results
        // for an empty term" listing every product.
        if (blank($searchTerm) && ! $activeCategory) {
            return $this->ecosystem($categories);
        }

        $query = Product::query()
            ->published()
            ->with(['category', 'images' => fn ($q) => $q->where('is_primary', true)]);

        if ($activeCategory) {
            $categoryIds = [$activeCategory->id, ...$activeCategory->children()->pluck('id')];
            $query->whereIn('category_id', $categoryIds);

            $activeCategory->coverProduct = Product::published()
                ->whereIn('category_id', $categoryIds)
                ->with(['images' => fn ($q) => $q->where('is_primary', true)])
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->first();
        }

        if (filled($searchTerm)) {
            $nameField = app()->getLocale() === 'en' ? 'name_en' : 'name';
            $descField = app()->getLocale() === 'en' ? 'short_description_en' : 'short_description';

            $query->where(function ($q) use ($searchTerm, $nameField, $descField) {
                $q->where($nameField, 'like', "%{$searchTerm}%")
                    ->orWhere($descField, 'like', "%{$searchTerm}%")
                    ->orWhere('model_number', 'like', "%{$searchTerm}%");

                // A translation may not exist yet for every product — also
                // match the Vietnamese source so a search never silently
                // returns nothing just because name_en is still blank.
                if ($nameField !== 'name') {
                    $q->orWhere('name', 'like', "%{$searchTerm}%");
                }
            });
        }

        $products = $query->orderBy('sort_order')->paginate(12)->withQueryString();

        if ($activeCategory) {
            return view('products.category', [
                'products' => $products,
                'categories' => $categories,
                'activeCategory' => $activeCategory,
                'relatedCategories' => $categories->where('id', '!=', $activeCategory->id)->take(4),
                'searchTerm' => $searchTerm,
            ]);
        }

        return view('products.search', [
            'products' => $products,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
        ]);
    }

    private function ecosystem($categories)
    {
        // Each category card shows a real product photo (never a stock/
        // fabricated image) — the category's featured product first, falling
        // back to its first published product by display order.
        foreach ($categories as $category) {
            $category->coverProduct = Product::published()
                ->where('category_id', $category->id)
                ->with(['images' => fn ($q) => $q->where('is_primary', true)])
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->first();
        }

        $featuredProducts = Product::published()
            ->where('is_featured', true)
            ->with(['category', 'images' => fn ($q) => $q->where('is_primary', true)])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('products.ecosystem', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'totalProducts' => Product::published()->count(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless(
            $product->status === Product::STATUS_PUBLISHED
                && (! $product->published_at || $product->published_at->lte(now())),
            404
        );

        $product->load(['category', 'images', 'specs']);

        // Documents are locale-specific rows (see product_documents.locale);
        // fall back to the Vietnamese edition when no English document has
        // been uploaded yet, rather than showing an empty list.
        $documents = $product->documents()->forLocale(app()->getLocale())->get();
        if ($documents->isEmpty() && app()->getLocale() === 'en') {
            $documents = $product->documents()->forLocale('vi')->get();
        }

        $relatedProducts = Product::published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => fn ($q) => $q->where('is_primary', true)])
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'documents' => $documents,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
