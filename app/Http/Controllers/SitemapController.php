<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        foreach ([
            ['home', 1.0, 'daily'], ['nosotros', 0.7, 'monthly'],
            ['servicios', 0.9, 'weekly'], ['catalogo', 0.8, 'weekly'],
            ['marcas', 0.7, 'weekly'], ['blog', 0.8, 'daily'], ['contacto', 0.6, 'monthly'],
        ] as [$route, $priority, $freq]) {
            $sitemap->add(Url::create(route($route))->setPriority($priority)->setChangeFrequency($freq));
        }

        Service::active()->ordered()->each(fn ($s) =>
            $sitemap->add(Url::create(route('servicios.show', $s->slug))->setPriority(0.9)->setChangeFrequency('monthly'))
        );
        Category::active()->each(fn ($c) =>
            $sitemap->add(Url::create(route('catalogo.categoria', $c->slug))->setPriority(0.8)->setChangeFrequency('weekly'))
        );
        Product::with('category')->active()->each(fn ($p) =>
            $sitemap->add(Url::create(route('catalogo.producto', [$p->category->slug, $p->slug]))->setPriority(0.7)->setChangeFrequency('weekly'))
        );
        Brand::active()->each(fn ($b) =>
            $sitemap->add(Url::create(route('marcas.show', $b->slug))->setPriority(0.7))
        );
        BlogPost::published()->latest()->each(fn ($post) =>
            $sitemap->add(Url::create(route('blog.show', $post->slug))->setPriority(0.6)->setChangeFrequency('monthly'))
        );

        return $sitemap->toResponse(request());
    }
}
