<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoInfrastructureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'https://opticaandina.com']);
    }

    public function test_sitemap_index_contains_expected_sections_including_images(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee('/sitemaps/pages.xml', false);
        $response->assertSee('/sitemaps/services.xml', false);
        $response->assertSee('/sitemaps/categories.xml', false);
        $response->assertSee('/sitemaps/products.xml', false);
        $response->assertSee('/sitemaps/brands.xml', false);
        $response->assertSee('/sitemaps/articles.xml', false);
        $response->assertSee('/sitemaps/images.xml', false);
    }

    public function test_images_sitemap_includes_product_blog_and_gallery_images(): void
    {
        $category = Category::create([
            'name' => 'Lentes Hombre',
            'slug' => 'lentes-hombre',
            'is_active' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Montura Alfa',
            'slug' => 'montura-alfa',
            'is_active' => true,
            'is_available' => true,
        ]);
        ProductImage::create([
            'product_id' => $product->id,
            'path' => 'products/alfa.jpg',
            'alt' => 'Montura Alfa',
            'is_cover' => true,
        ]);

        BlogPost::create([
            'title' => 'Cuidado visual',
            'slug' => 'cuidado-visual',
            'content' => 'Contenido del articulo',
            'image' => 'blog/cuidado.jpg',
            'is_published' => true,
            'published_at' => now(),
        ]);

        Media::create([
            'filename' => 'galeria-1',
            'path' => 'media/galeria-1.jpg',
            'mime_type' => 'image/jpeg',
            'size' => 12000,
            'alt' => 'Galeria 1',
        ]);

        $response = $this->get('/sitemaps/images.xml');

        $response->assertOk();
        $response->assertSee('xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"', false);
        $response->assertSee('products/alfa.jpg', false);
        $response->assertSee('blog/cuidado.jpg', false);
        $response->assertSee('media/galeria-1.jpg', false);
    }

    public function test_robots_txt_has_disallow_and_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
        $response->assertSee('Disallow: /admin');
        $response->assertSee('Disallow: /checkout/*');
        $response->assertSee('Sitemap: https://opticaandina.com/sitemap.xml');
    }

    public function test_filtered_urls_are_noindex_and_keep_clean_canonical(): void
    {
        $response = $this->get('/blog?page=2&utm_source=test');

        $response->assertOk();
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
        $response->assertSee('<link rel="canonical" href="https://opticaandina.com/blog">', false);
    }

    public function test_clean_urls_are_indexable_with_canonical(): void
    {
        $response = $this->get('/blog');

        $response->assertOk();
        $response->assertSee('<meta name="robots" content="index, follow">', false);
        $response->assertSee('<link rel="canonical" href="https://opticaandina.com/blog">', false);
    }

    public function test_product_schema_without_price_has_no_offers_and_with_price_has_offers(): void
    {
        $category = Category::create([
            'name' => 'Lentes Mujer',
            'slug' => 'lentes-mujer',
            'is_active' => true,
        ]);

        $withoutPrice = Product::create([
            'category_id' => $category->id,
            'name' => 'Montura Sin Precio',
            'slug' => 'montura-sin-precio',
            'is_active' => true,
            'is_available' => true,
            'price' => null,
        ]);

        $withPrice = Product::create([
            'category_id' => $category->id,
            'name' => 'Montura Con Precio',
            'slug' => 'montura-con-precio',
            'is_active' => true,
            'is_available' => true,
            'price' => 129.90,
        ]);

        $schemaWithout = json_decode((string) SeoService::forProduct($withoutPrice)['schema'], true);
        $schemaWith = json_decode((string) SeoService::forProduct($withPrice)['schema'], true);

        $this->assertIsArray($schemaWithout);
        $this->assertIsArray($schemaWith);
        $this->assertArrayNotHasKey('offers', $schemaWithout);
        $this->assertArrayHasKey('offers', $schemaWith);
        $this->assertSame('129.90', $schemaWith['offers']['price']);
    }
}
