<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\MediaUrl;

class SeoService
{
    public static function forPage(string $pageKey): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $meta = SeoMeta::getForPage($pageKey);

        return [
            'title' => $meta?->title ?? $siteName,
            'meta_description' => $meta?->meta_description ?? SiteSetting::get('seo_description', ''),
            'og_title' => $meta?->og_title ?? $meta?->title ?? $siteName,
            'og_description' => $meta?->og_description ?? $meta?->meta_description ?? '',
            'og_image' => MediaUrl::image($meta?->og_image) ?? MediaUrl::image(SiteSetting::get('og_image', '')),
            'canonical' => $meta?->canonical ?? url()->current(),
            'noindex' => $meta?->noindex ?? false,
            'schema' => null,
            'site_name' => $siteName,
        ];
    }

    public static function forProduct(Product $product): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $ogImage = $product->coverImage
            ? MediaUrl::image($product->coverImage->path)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => strip_tags($product->short_description ?? $product->name),
            'url' => route('catalogo.producto', [$product->category->slug ?? 'general', $product->slug]),
            'offers' => [
                '@type' => 'Offer',
                'availability' => $product->is_available
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'priceCurrency' => 'USD',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $siteName,
                ],
            ],
        ];

        if ($product->brand) {
            $schema['brand'] = ['@type' => 'Brand', 'name' => $product->brand->name];
        }

        if ($product->coverImage) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => MediaUrl::image($product->coverImage->path),
            ];
        }

        if ($product->category) {
            $schema['category'] = $product->category->name;
        }

        return [
            'title' => $product->meta_title ?? $product->name.' – '.$siteName,
            'meta_description' => $product->meta_description ?? strip_tags($product->short_description ?? ''),
            'og_title' => $product->meta_title ?? $product->name,
            'og_description' => strip_tags($product->short_description ?? ''),
            'og_image' => $ogImage,
            'og_type' => 'product',
            'canonical' => url()->current(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'site_name' => $siteName,
        ];
    }

    public static function forService(Service $service): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $ogImage = $service->image
            ? MediaUrl::image($service->image)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service->title,
            'description' => strip_tags($service->excerpt ?? ''),
            'url' => route('servicios.show', $service->slug),
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => $siteName,
                '@id' => config('app.url').'/#business',
            ],
        ];

        if ($service->image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => MediaUrl::image($service->image),
            ];
        }

        $faqSchema = null;
        if (! empty($service->faqs)) {
            $faqSchema = json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(fn ($faq) => [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => strip_tags($faq['answer']),
                    ],
                ], $service->faqs),
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return [
            'title' => $service->meta_title ?? $service->title.' – '.$siteName,
            'meta_description' => $service->meta_description ?? strip_tags($service->excerpt ?? ''),
            'og_title' => $service->title,
            'og_description' => strip_tags($service->excerpt ?? ''),
            'og_image' => $ogImage,
            'canonical' => url()->current(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'faq_schema' => $faqSchema,
            'site_name' => $siteName,
        ];
    }

    public static function forBlogPost(BlogPost $post): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Andina');
        $ogImage = $post->image
            ? MediaUrl::image($post->image)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $post->slug),
            ],
            'headline' => $post->title,
            'description' => strip_tags($post->excerpt ?? ''),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'url' => config('app.url'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                'url' => config('app.url'),
            ],
        ];

        if ($post->image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => MediaUrl::image($post->image),
            ];
        }

        return [
            'title' => $post->meta_title ?? $post->title.' – '.$siteName,
            'meta_description' => $post->meta_description ?? strip_tags($post->excerpt ?? ''),
            'og_title' => $post->title,
            'og_description' => strip_tags($post->excerpt ?? ''),
            'og_image' => $ogImage,
            'og_type' => 'article',
            'canonical' => url()->current(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'site_name' => $siteName,
        ];
    }

    /**
     * Schema LocalBusiness enriquecido — tipo Optician para la home.
     */
    public static function localBusinessSchema(): array
    {
        $settings = SiteSetting::getAll();
        $name = $settings['site_name'] ?? 'Óptica Andina';
        $phone = $settings['phone'] ?? '';
        $address = $settings['address'] ?? 'Tumbaco, Pichincha, Ecuador';
        $email = $settings['email'] ?? '';
        $appUrl = config('app.url');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Optician',
            '@id' => $appUrl.'/#business',
            'name' => $name,
            'url' => $appUrl,
            'description' => $settings['seo_description'] ?? 'Especialistas en salud visual en Tumbaco, Quito.',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address,
                'addressLocality' => 'Tumbaco',
                'addressRegion' => 'Pichincha',
                'postalCode' => '170184',
                'addressCountry' => 'EC',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => -0.2167,
                'longitude' => -78.3833,
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '09:00',
                    'closes' => '18:00',
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Saturday'],
                    'opens' => '09:00',
                    'closes' => '14:00',
                ],
            ],
            'priceRange' => '$$',
            'currenciesAccepted' => 'USD',
            'paymentAccepted' => 'Efectivo, Tarjeta de crédito',
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Tumbaco'],
                ['@type' => 'City', 'name' => 'Cumbayá'],
                ['@type' => 'City', 'name' => 'Quito'],
            ],
        ];

        if ($phone) {
            $schema['telephone'] = $phone;
        }

        if ($email) {
            $schema['email'] = $email;
        }

        // Logo desde settings o archivo estático
        $logoPath = $settings['logo_header'] ?? '';
        if ($logoPath) {
            $schema['logo'] = [
                '@type' => 'ImageObject',
                'url' => MediaUrl::image($logoPath),
            ];
        } elseif (file_exists(public_path('images/brand/logo-full.svg'))) {
            $schema['logo'] = [
                '@type' => 'ImageObject',
                'url' => asset('images/brand/logo-full.svg'),
            ];
        }

        // Redes sociales → sameAs
        $sameAs = [];
        if (! empty($settings['facebook_url'])) {
            $sameAs[] = $settings['facebook_url'];
        }
        if (! empty($settings['instagram_url'])) {
            $sameAs[] = $settings['instagram_url'];
        }
        if (! empty($settings['tiktok_url'])) {
            $sameAs[] = $settings['tiktok_url'];
        }
        if ($sameAs) {
            $schema['sameAs'] = $sameAs;
        }

        // Google Maps
        if (! empty($settings['maps_url'])) {
            $schema['hasMap'] = $settings['maps_url'];
        }

        return $schema;
    }

    /**
     * Genera JSON-LD BreadcrumbList.
     * $crumbs = [['name' => 'Blog', 'url' => '...'], ['name' => 'Título del post']]
     * "Inicio" se añade automáticamente como primer ítem.
     */
    public static function breadcrumbSchema(array $crumbs): string
    {
        $items = [[
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Inicio',
            'item' => config('app.url'),
        ]];

        foreach ($crumbs as $i => $crumb) {
            $item = [
                '@type' => 'ListItem',
                'position' => $i + 2,
                'name' => $crumb['name'],
            ];
            if (! empty($crumb['url'])) {
                $item['item'] = $crumb['url'];
            }
            $items[] = $item;
        }

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * WebSite schema con SearchAction (sitelinks searchbox de Google).
     */
    public static function websiteSchema(): string
    {
        $url = config('app.url');
        $name = SiteSetting::get('site_name', 'Óptica Andina');

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $url.'/#website',
            'url' => $url,
            'name' => $name,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $url.'/catalogo?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
