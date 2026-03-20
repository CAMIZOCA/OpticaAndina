<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\SeoService;

class BrandController extends Controller
{
    public function index()
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo = [
            'title' => 'Marcas – ' . $siteName,
            'meta_description' => 'Conoce las marcas de monturas y lentes en ' . $siteName . ' – Tumbaco, Ecuador.',
            'og_title' => 'Marcas – ' . $siteName, 'og_description' => '', 'og_image' => '',
            'canonical' => null, 'noindex' => false, 'schema' => null, 'site_name' => $siteName,
        ];
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Marcas', 'url' => route('marcas')],
        ]);
        $brands = Brand::active()->withCount(['products' => fn ($q) => $q->active()])->get();
        return view('pages.marcas.index', compact('seo', 'brands'));
    }

    public function show(string $slug)
    {
        $brand    = Brand::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $seo = [
            'title' => $brand->name . ' – ' . $siteName,
            'meta_description' => 'Productos de ' . $brand->name . ' en ' . $siteName . ', Tumbaco.',
            'og_title' => $brand->name, 'og_description' => $brand->description ?? '',
            'og_image' => $brand->logo ? asset('storage/' . $brand->logo) : '',
            'canonical' => null, 'noindex' => false, 'site_name' => $siteName,
        ];
        $seo['schema'] = json_encode([
            '@context' => 'https://schema.org',
            '@type'    => 'Brand',
            'name'     => $brand->name,
            'url'      => route('marcas.show', $brand->slug),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $seo['breadcrumb_schema'] = SeoService::breadcrumbSchema([
            ['name' => 'Marcas', 'url' => route('marcas')],
            ['name' => $brand->name],
        ]);
        $products = Product::with(['category', 'brand', 'images'])
            ->active()->where('brand_id', $brand->id)->paginate(12);
        return view('pages.marcas.show', compact('seo', 'brand', 'products'));
    }
}
