<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\SeoService;
use App\Support\MediaUrl;

class BrandController extends Controller
{
    public function index()
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $withProductCount = ['products' => fn ($q) => $q->active()];

        $featuredBrands = Brand::active()->featured()
            ->withCount($withProductCount)
            ->orderBy('name')
            ->get();
        $regularBrands = Brand::active()->where('is_featured', false)
            ->withCount($withProductCount)
            ->orderBy('name')
            ->get();
        $allBrands = $featuredBrands->concat($regularBrands);

        $seo = SeoService::applyDefaults([
            'title' => 'Marcas | '.$siteName,
            'meta_description' => 'Marcas de monturas y lentes disponibles en '.$siteName.' en Tumbaco, Quito.',
            'og_title' => 'Marcas | '.$siteName,
            'og_description' => 'Marcas disponibles en Optica Andina.',
            'og_image' => '',
            'canonical' => SeoService::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => SeoService::collectionPageSchema(
                'Marcas',
                route('marcas'),
                $allBrands->map(fn (Brand $brand) => [
                    'name' => $brand->name,
                    'url' => route('marcas.show', $brand->slug),
                    'image' => MediaUrl::image($brand->logo),
                ])->all(),
                'Listado de marcas de monturas y lentes.'
            ),
            'site_name' => $siteName,
        ]);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Marcas', 'url' => route('marcas')],
        ]);

        return view('pages.marcas.index', compact('seo', 'featuredBrands', 'regularBrands'));
    }

    public function show(string $slug)
    {
        $brand = Brand::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $siteName = SiteSetting::get('site_name', 'Optica Andina');

        $products = Product::with(['category', 'categories', 'brand', 'images'])
            ->active()->where('brand_id', $brand->id)->paginate(12);

        $seo = SeoService::applyDefaults([
            'title' => $brand->name.' | '.$siteName,
            'meta_description' => $brand->description ?: ('Productos de '.$brand->name.' en '.$siteName.', Tumbaco.'),
            'og_title' => $brand->name,
            'og_description' => $brand->description ?? '',
            'og_image' => MediaUrl::image($brand->logo) ?? '',
            'canonical' => SeoService::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => SeoService::collectionPageSchema(
                $brand->name,
                route('marcas.show', $brand->slug),
                $products->getCollection()->map(fn (Product $product) => [
                    'name' => $product->name,
                    'url' => $product->category
                        ? route('catalogo.producto', [$product->category->slug, $product->slug])
                        : route('catalogo'),
                    'image' => optional($product->coverImage)->path ? MediaUrl::image($product->coverImage->path) : null,
                ])->all(),
                'Productos disponibles de la marca '.$brand->name
            ),
            'site_name' => $siteName,
        ]);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Marcas', 'url' => route('marcas')],
            ['name' => $brand->name],
        ]);

        return view('pages.marcas.show', compact('seo', 'brand', 'products'));
    }
}
