<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Services\SeoService;

class HomeController extends Controller
{
    public function index()
    {
        $seo = SeoService::forPage('home');
        $seo['schema'] = json_encode(SeoService::localBusinessSchema(), JSON_UNESCAPED_UNICODE);

        $featuredProducts = Product::with(['category', 'brand', 'images'])
            ->active()->available()->featured()->ordered()->limit(8)->get();
        $services    = Service::active()->ordered()->limit(6)->get();
        $brands      = Brand::active()->limit(8)->get();
        $categories  = Category::active()->root()->ordered()->get();
        $latestPosts = BlogPost::published()->latest()->limit(3)->get();

        return view('pages.home', compact('seo', 'featuredProducts', 'services', 'brands', 'categories', 'latestPosts'));
    }

    public function nosotros()
    {
        $seo = SeoService::forPage('nosotros');
        return view('pages.nosotros', compact('seo'));
    }
}
