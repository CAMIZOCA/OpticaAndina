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

        return view('pages.catalogo.index', compact('seo', 'categories', 'saleProducts', 'saleTotalCount'));
    }

    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->where('is_active', true)->firstOrFail();
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo = [
            'title' => $category->meta_title ?? $category->name.' – '.$siteName,
            'meta_description' => $category->meta_description ?? '',
            'og_title' => $category->name,
            'og_description' => $category->description ?? '',
            'og_image' => MediaUrl::image($category->image) ?? '',
            'canonical' => null,
            'noindex' => false,
            'schema' => null,
            'site_name' => $siteName,
        ];
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Catálogo', 'url' => route('catalogo')],
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
            ['name' => 'Catálogo', 'url' => route('catalogo')],
            ['name' => $category->name, 'url' => route('catalogo.categoria', $category->slug)],
            ['name' => $product->name],
        ]);
        $related = Product::with(['category', 'brand', 'images'])
            ->active()->where('category_id', $category->id)->where('id', '!=', $product->id)->limit(4)->get();
        $stripeEnabled = SiteSetting::get('stripe_enabled', '0') === '1';

        return view('pages.catalogo.product', compact('seo', 'category', 'product', 'related', 'stripeEnabled'));
    }
}
