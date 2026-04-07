<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\SeoService;
use App\Support\MediaUrl;

class CatalogController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('catalogo');
        $categories = Category::active()->root()->ordered()
            ->withCount(['products' => fn ($q) => $q->active()])
            ->get();

        $saleProducts = Product::with(['category', 'brand', 'images'])->active()->onSale()->latest()->limit(8)->get();
        $saleTotalCount = Product::active()->onSale()->count();

        $seo['schema'] = SeoService::collectionPageSchema(
            'Catalogo',
            route('catalogo'),
            $categories->map(fn (Category $category) => [
                'name' => $category->name,
                'url' => route('catalogo.categoria', $category->slug),
                'image' => MediaUrl::image($category->image),
            ])->all(),
            'Categorias y productos de Optica Andina en Tumbaco.'
        );
        $seo = SeoService::applyDefaults($seo);

        return view('pages.catalogo.index', compact('seo', 'categories', 'saleProducts', 'saleTotalCount'));
    }

    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->where('is_active', true)->firstOrFail();
        $siteName = SiteSetting::get('site_name', 'Optica Andina');

        $schemaItems = Product::with(['images'])
            ->active()
            ->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id))
            ->latest()
            ->limit(24)
            ->get()
            ->map(fn (Product $product) => [
                'name' => $product->name,
                'url' => route('catalogo.producto', [$category->slug, $product->slug]),
                'image' => optional($product->coverImage)->path ? MediaUrl::image($product->coverImage->path) : null,
            ])->all();

        $seo = SeoService::applyDefaults([
            'title' => $category->meta_title ?? $category->name.' | '.$siteName,
            'meta_description' => $category->meta_description ?? ($category->description ?: 'Productos de '.$category->name.' en Optica Andina.'),
            'og_title' => $category->name,
            'og_description' => $category->description ?? '',
            'og_image' => MediaUrl::image($category->image) ?? '',
            'canonical' => SeoService::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => SeoService::collectionPageSchema(
                $category->name,
                route('catalogo.categoria', $category->slug),
                $schemaItems,
                $category->description ?: 'Productos de '.$category->name.' en Optica Andina.'
            ),
            'site_name' => $siteName,
        ]);

        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Catalogo', 'url' => route('catalogo')],
            ['name' => $category->name],
        ]);

        $brands = Brand::active()->get();

        return view('pages.catalogo.category', compact('seo', 'category', 'brands'));
    }

    public function product(string $categorySlug, string $productSlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $product = Product::with(['category', 'brand', 'images'])
            ->where('slug', $productSlug)
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $seo = SeoService::forProduct($product);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Catalogo', 'url' => route('catalogo')],
            ['name' => $category->name, 'url' => route('catalogo.categoria', $category->slug)],
            ['name' => $product->name],
        ]);
        $seo = SeoService::applyDefaults($seo);

        $related = Product::with(['category', 'brand', 'images'])
            ->active()->where('category_id', $category->id)->where('id', '!=', $product->id)->limit(4)->get();
        $stripeEnabled = SiteSetting::get('stripe_enabled', '0') === '1';

        return view('pages.catalogo.product', compact('seo', 'category', 'product', 'related', 'stripeEnabled'));
    }
}
