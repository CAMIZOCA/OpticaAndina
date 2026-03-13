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

        // Páginas estáticas
        foreach ([
            ['home',      1.0, 'daily'],
            ['nosotros',  0.7, 'monthly'],
            ['servicios', 0.9, 'weekly'],
            ['catalogo',  0.8, 'weekly'],
            ['marcas',    0.7, 'weekly'],
            ['blog',      0.8, 'daily'],
            ['contacto',  0.6, 'monthly'],
        ] as [$route, $priority, $freq]) {
            $sitemap->add(
                Url::create(route($route))
                    ->setPriority($priority)
                    ->setChangeFrequency($freq)
            );
        }

        // Servicios
        Service::active()->ordered()->each(function ($s) use ($sitemap) {
            $sitemap->add(
                Url::create(route('servicios.show', $s->slug))
                    ->setPriority(0.9)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($s->updated_at)
            );
        });

        // Categorías
        Category::active()->each(function ($c) use ($sitemap) {
            $sitemap->add(
                Url::create(route('catalogo.categoria', $c->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($c->updated_at)
            );
        });

        // Productos — solo los que tienen categoría
        Product::with('category')
            ->active()
            ->whereHas('category')
            ->each(function ($p) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('catalogo.producto', [$p->category->slug, $p->slug]))
                        ->setPriority(0.7)
                        ->setChangeFrequency('weekly')
                        ->setLastModificationDate($p->updated_at)
                );
            });

        // Marcas
        Brand::active()->each(function ($b) use ($sitemap) {
            $sitemap->add(
                Url::create(route('marcas.show', $b->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($b->updated_at)
            );
        });

        // Blog posts
        BlogPost::published()->latest()->each(function ($post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setPriority(0.6)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($post->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }
}
