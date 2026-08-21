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
            $nameField = app()->getLocale() === 'en' ? 'name_en' : 'name';
            $descField = app()->getLocale() === 'en' ? 'short_description_en' : 'short_description';

            $query->where(function ($q) use ($search, $nameField, $descField) {
                $q->where($nameField, 'like', "%{$search}%")
                    ->orWhere($descField, 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%");

                // A translation may not exist yet for every product — also
                // match the Vietnamese source so a search never silently
                // returns nothing just because name_en is still blank.
                if ($nameField !== 'name') {
                    $q->orWhere('name', 'like', "%{$search}%");
                }
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
