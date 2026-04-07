<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\Service;
use Carbon\CarbonInterface;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Sitemap as SitemapTag;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    private const CACHE_TTL_SECONDS = 900;

    public function index()
    {
        return $this->cachedXmlResponse('seo:sitemap:index', function () {
            $index = SitemapIndex::create()
                ->add($this->makeIndexTag(route('sitemap.pages'), now()))
                ->add($this->makeIndexTag(route('sitemap.services'), Service::active()->max('updated_at')))
                ->add($this->makeIndexTag(route('sitemap.categories'), Category::active()->max('updated_at')))
                ->add($this->makeIndexTag(route('sitemap.products'), Product::active()->max('updated_at')))
                ->add($this->makeIndexTag(route('sitemap.brands'), Brand::active()->max('updated_at')))
                ->add($this->makeIndexTag(route('sitemap.articles'), BlogPost::published()->max('updated_at')))
                ->add($this->makeIndexTag(route('sitemap.images'), $this->imagesLastModifiedAt()));

            return $index;
        });
    }

    public function pages()
    {
        return $this->cachedXmlResponse('seo:sitemap:pages', function () {
            $sitemap = Sitemap::create();

            foreach ($this->staticPages() as [$route, $priority, $frequency]) {
                $sitemap->add(
                    Url::create(route($route))
                        ->setPriority($priority)
                        ->setChangeFrequency($frequency)
                        ->setLastModificationDate(now())
                );
            }

            return $sitemap;
        });
    }

    public function services()
    {
        return $this->cachedXmlResponse('seo:sitemap:services', function () {
            $sitemap = Sitemap::create();

            Service::active()->ordered()->each(function ($service) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('servicios.show', $service->slug))
                        ->setPriority(0.9)
                        ->setChangeFrequency('monthly')
                        ->setLastModificationDate($this->normalizeLastModificationDate($service->updated_at) ?? now())
                );
            });

            return $sitemap;
        });
    }

    public function categories()
    {
        return $this->cachedXmlResponse('seo:sitemap:categories', function () {
            $sitemap = Sitemap::create();

            Category::active()->ordered()->each(function ($category) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('catalogo.categoria', $category->slug))
                        ->setPriority(0.8)
                        ->setChangeFrequency('weekly')
                        ->setLastModificationDate($this->normalizeLastModificationDate($category->updated_at) ?? now())
                );
            });

            return $sitemap;
        });
    }

    public function products()
    {
        return $this->cachedXmlResponse('seo:sitemap:products', function () {
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
                            ->setLastModificationDate($this->normalizeLastModificationDate($product->updated_at) ?? now())
                    );
                });

            return $sitemap;
        });
    }

    public function brands()
    {
        return $this->cachedXmlResponse('seo:sitemap:brands', function () {
            $sitemap = Sitemap::create();

            Brand::active()->each(function ($brand) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('marcas.show', $brand->slug))
                        ->setPriority(0.7)
                        ->setChangeFrequency('monthly')
                        ->setLastModificationDate($this->normalizeLastModificationDate($brand->updated_at) ?? now())
                );
            });

            return $sitemap;
        });
    }

    public function articles()
    {
        return $this->cachedXmlResponse('seo:sitemap:articles', function () {
            $sitemap = Sitemap::create();

            BlogPost::published()->latest()->each(function ($post) use ($sitemap) {
                $sitemap->add(
                    Url::create(route('blog.show', $post->slug))
                        ->setPriority(0.6)
                        ->setChangeFrequency('monthly')
                        ->setLastModificationDate($this->normalizeLastModificationDate($post->updated_at) ?? now())
                );
            });

            return $sitemap;
        });
    }

    public function images()
    {
        return $this->cachedXmlResponse('seo:sitemap:images', function () {
            $sitemap = Sitemap::create();

            Product::with(['category', 'images'])
                ->active()
                ->whereHas('category')
                ->each(function (Product $product) use ($sitemap) {
                    $url = Url::create(route('catalogo.producto', [$product->category->slug, $product->slug]))
                        ->setLastModificationDate($this->normalizeLastModificationDate($product->updated_at) ?? now());

                    foreach ($product->images as $image) {
                        $imageUrl = \App\Support\MediaUrl::image($image->path);
                        if ($imageUrl) {
                            $url->addImage($imageUrl, $image->alt ?? '', 'Tumbaco, Quito', $product->name);
                        }
                    }

                    if (! empty($url->images)) {
                        $sitemap->add($url);
                    }
                });

            BlogPost::published()->each(function (BlogPost $post) use ($sitemap) {
                $imageUrl = \App\Support\MediaUrl::image($post->image);
                if (! $imageUrl) {
                    return;
                }

                $sitemap->add(
                    Url::create(route('blog.show', $post->slug))
                        ->setLastModificationDate($this->normalizeLastModificationDate($post->updated_at) ?? now())
                        ->addImage($imageUrl, $post->excerpt ?? '', 'Tumbaco, Quito', $post->title)
                );
            });

            Media::query()->each(function (Media $media) use ($sitemap) {
                if (! $media->url) {
                    return;
                }

                $sitemap->add(
                    Url::create(route('galeria'))
                        ->setLastModificationDate($this->normalizeLastModificationDate($media->updated_at) ?? now())
                        ->addImage($media->url, $media->alt ?? '', 'Tumbaco, Quito', $media->filename)
                );
            });

            return $sitemap;
        });
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
            ['galeria', 0.6, 'weekly'],
            ['contacto', 0.6, 'monthly'],
        ];
    }

    private function makeIndexTag(string $url, mixed $lastModificationDate = null): SitemapTag
    {
        $tag = SitemapTag::create($url);
        $lastModificationDate = $this->normalizeLastModificationDate($lastModificationDate) ?? now();
        $tag->setLastModificationDate($lastModificationDate);

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

    private function imagesLastModifiedAt(): ?CarbonInterface
    {
        $dates = [
            Product::active()->max('updated_at'),
            BlogPost::published()->max('updated_at'),
            Media::max('updated_at'),
        ];

        foreach ($dates as $date) {
            $normalized = $this->normalizeLastModificationDate($date);
            if ($normalized) {
                return $normalized;
            }
        }

        return now();
    }

    private function cachedXmlResponse(string $key, Closure $builder)
    {
        $xml = Cache::remember($key, self::CACHE_TTL_SECONDS, function () use ($builder) {
            return $builder()->render();
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
