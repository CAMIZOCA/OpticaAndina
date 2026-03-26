<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap as SitemapTag;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        if ($section = $request->query('section')) {
            return $this->sectionResponse($section);
        }

        $index = SitemapIndex::create()
            ->add($this->makeIndexTag($this->sectionUrl('pages'), now()))
            ->add($this->makeIndexTag($this->sectionUrl('services'), Service::active()->max('updated_at')))
            ->add($this->makeIndexTag($this->sectionUrl('categories'), Category::active()->max('updated_at')))
            ->add($this->makeIndexTag($this->sectionUrl('products'), Product::active()->max('updated_at')))
            ->add($this->makeIndexTag($this->sectionUrl('brands'), Brand::active()->max('updated_at')))
            ->add($this->makeIndexTag($this->sectionUrl('articles'), BlogPost::published()->max('updated_at')));

        return $index->toResponse(request());
    }

    public function pages()
    {
        $sitemap = Sitemap::create();

        foreach ($this->staticPages() as [$route, $priority, $frequency]) {
            $sitemap->add(
                Url::create(route($route))
                    ->setPriority($priority)
                    ->setChangeFrequency($frequency)
            );
        }

        return $sitemap->toResponse(request());
    }

    public function services()
    {
        $sitemap = Sitemap::create();

        Service::active()->ordered()->each(function ($service) use ($sitemap) {
            $sitemap->add(
                Url::create(route('servicios.show', $service->slug))
                    ->setPriority(0.9)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($service->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }

    public function categories()
    {
        $sitemap = Sitemap::create();

        Category::active()->ordered()->each(function ($category) use ($sitemap) {
            $sitemap->add(
                Url::create(route('catalogo.categoria', $category->slug))
                    ->setPriority(0.8)
                    ->setChangeFrequency('weekly')
                    ->setLastModificationDate($category->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }

    public function products()
    {
        $sitemap = Sitemap::create();

        Product::with('category')
            ->active()
            ->whereHas('category')
            ->ordered()
            ->each(function ($product) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('catalogo.producto', [$product->category->slug, $product->slug]))
                        ->setPriority(0.7)
                        ->setChangeFrequency('weekly')
                        ->setLastModificationDate($product->updated_at)
                );
            });

        return $sitemap->toResponse(request());
    }

    public function brands()
    {
        $sitemap = Sitemap::create();

        Brand::active()->each(function ($brand) use ($sitemap) {
            $sitemap->add(
                Url::create(route('marcas.show', $brand->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency('monthly')
                    ->setLastModificationDate($brand->updated_at)
            );
        });

        return $sitemap->toResponse(request());
    }

    public function articles()
    {
        $sitemap = Sitemap::create();

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

    private function staticPages(): array
    {
        return [
            ['home', 1.0, 'daily'],
            ['nosotros', 0.7, 'monthly'],
            ['servicios', 0.9, 'weekly'],
            ['catalogo', 0.8, 'weekly'],
            ['marcas', 0.7, 'weekly'],
            ['blog', 0.8, 'daily'],
            ['contacto', 0.6, 'monthly'],
        ];
    }

    private function sectionResponse(string $section)
    {
        return match ($section) {
            'pages' => $this->pages(),
            'services' => $this->services(),
            'categories' => $this->categories(),
            'products' => $this->products(),
            'brands' => $this->brands(),
            'articles' => $this->articles(),
            default => abort(404),
        };
    }

    private function sectionUrl(string $section): string
    {
        return url('/sitemap.xml?section='.$section);
    }

    private function makeIndexTag(string $url, mixed $lastModificationDate = null): SitemapTag
    {
        $tag = SitemapTag::create($url);
        $lastModificationDate = $this->normalizeLastModificationDate($lastModificationDate);

        if ($lastModificationDate) {
            $tag->setLastModificationDate($lastModificationDate);
        }

        return $tag;
    }

    private function normalizeLastModificationDate(mixed $value): ?CarbonInterface
    {
        if ($value instanceof CarbonInterface) {
            return $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value);
        }

        if (is_string($value) && trim($value) !== '') {
            return Carbon::parse($value);
        }

        return null;
    }
}
