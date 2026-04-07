<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Product;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SeoService
{
    public static function forPage(string $pageKey): array
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $meta = SeoMeta::getForPage($pageKey);

        return static::applyDefaults([
            'title' => $meta?->title ?? $siteName,
            'meta_description' => $meta?->meta_description ?? static::defaultMetaDescription(),
            'og_title' => $meta?->og_title ?? $meta?->title ?? $siteName,
            'og_description' => $meta?->og_description ?? $meta?->meta_description ?? static::defaultMetaDescription(),
            'og_image' => MediaUrl::image($meta?->og_image) ?? MediaUrl::image(SiteSetting::get('og_image', '')),
            'canonical' => $meta?->canonical ?? static::canonicalForCurrentRequest(),
            'noindex' => (bool) ($meta?->noindex ?? false),
            'schema' => null,
            'site_name' => $siteName,
        ]);
    }

    public static function forProduct(Product $product): array
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $productUrl = route('catalogo.producto', [$product->category->slug ?? 'general', $product->slug]);
        $ogImage = $product->coverImage
            ? MediaUrl::image($product->coverImage->path)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $productUrl.'#product',
            'name' => $product->name,
            'description' => strip_tags($product->short_description ?? $product->name),
            'url' => $productUrl,
            'isPartOf' => ['@id' => static::hostUrl().'/#website'],
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

        // Avoid rich-result warnings by only publishing Offer when price exists.
        if (! is_null($product->price) && (float) $product->price > 0) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => number_format((float) $product->price, 2, '.', ''),
                'priceCurrency' => 'USD',
                'url' => $productUrl,
                'availability' => $product->is_available
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $siteName,
                    '@id' => static::hostUrl().'#business',
                ],
            ];
        }

        return static::applyDefaults([
            'title' => $product->meta_title ?? $product->name.' | '.$siteName,
            'meta_description' => $product->meta_description ?? strip_tags($product->short_description ?? static::defaultMetaDescription()),
            'og_title' => $product->meta_title ?? $product->name,
            'og_description' => strip_tags($product->short_description ?? static::defaultMetaDescription()),
            'og_image' => $ogImage,
            'og_type' => 'product',
            'canonical' => static::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'site_name' => $siteName,
        ]);
    }

    public static function forService(Service $service): array
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $serviceUrl = route('servicios.show', $service->slug);
        $ogImage = $service->image
            ? MediaUrl::image($service->image)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            '@id' => $serviceUrl.'#service',
            'name' => $service->title,
            'description' => strip_tags($service->excerpt ?? ''),
            'url' => $serviceUrl,
            'provider' => [
                '@type' => 'Optician',
                'name' => $siteName,
                '@id' => static::hostUrl().'/#business',
            ],
            'isPartOf' => ['@id' => static::hostUrl().'/#website'],
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

        return static::applyDefaults([
            'title' => $service->meta_title ?? $service->title.' | '.$siteName,
            'meta_description' => $service->meta_description ?? strip_tags($service->excerpt ?? static::defaultMetaDescription()),
            'og_title' => $service->title,
            'og_description' => strip_tags($service->excerpt ?? static::defaultMetaDescription()),
            'og_image' => $ogImage,
            'canonical' => static::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'faq_schema' => $faqSchema,
            'site_name' => $siteName,
        ]);
    }

    public static function forBlogPost(BlogPost $post): array
    {
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $postUrl = route('blog.show', $post->slug);
        $ogImage = $post->image
            ? MediaUrl::image($post->image)
            : MediaUrl::image(SiteSetting::get('og_image', ''));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            '@id' => $postUrl.'#article',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $postUrl,
            ],
            'headline' => $post->title,
            'description' => strip_tags($post->excerpt ?? static::defaultMetaDescription()),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $siteName,
                '@id' => static::hostUrl().'/#business',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteName,
                '@id' => static::hostUrl().'/#business',
                'url' => static::hostUrl(),
            ],
            'isPartOf' => ['@id' => static::hostUrl().'/#website'],
        ];

        $logoUrl = static::siteLogoUrl();
        if ($logoUrl) {
            $schema['publisher']['logo'] = [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ];
        }

        if ($post->image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => MediaUrl::image($post->image),
            ];
        }

        return static::applyDefaults([
            'title' => $post->meta_title ?? $post->title.' | '.$siteName,
            'meta_description' => $post->meta_description ?? strip_tags($post->excerpt ?? static::defaultMetaDescription()),
            'og_title' => $post->title,
            'og_description' => strip_tags($post->excerpt ?? static::defaultMetaDescription()),
            'og_image' => $ogImage,
            'og_type' => 'article',
            'canonical' => static::canonicalForCurrentRequest(),
            'noindex' => false,
            'schema' => json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'site_name' => $siteName,
        ]);
    }

    public static function applyDefaults(array $meta, ?Request $request = null): array
    {
        $request ??= request();
        $siteName = SiteSetting::get('site_name', 'Optica Andina');
        $descriptionFallback = static::defaultMetaDescription();
        $ogImageFallback = MediaUrl::image(SiteSetting::get('og_image', ''));

        $meta['title'] = trim((string) ($meta['title'] ?? $siteName));
        $meta['meta_description'] = trim((string) ($meta['meta_description'] ?? '')) ?: $descriptionFallback;
        $meta['og_title'] = trim((string) ($meta['og_title'] ?? '')) ?: $meta['title'];
        $meta['og_description'] = trim((string) ($meta['og_description'] ?? '')) ?: $meta['meta_description'];
        $meta['og_image'] = $meta['og_image'] ?? $ogImageFallback;
        $meta['site_name'] = trim((string) ($meta['site_name'] ?? '')) ?: $siteName;
        $meta['canonical'] = static::normalizeCanonicalToPreferredHost(
            (string) ($meta['canonical'] ?? static::canonicalForRequest($request))
        );
        $meta['og_type'] = $meta['og_type'] ?? 'website';
        $meta['og_locale'] = $meta['og_locale'] ?? SiteSetting::get('og_locale', 'es_EC');
        $meta['twitter_site'] = $meta['twitter_site'] ?? static::resolveTwitterHandle(
            SiteSetting::get('twitter_site', SiteSetting::get('twitter_handle', SiteSetting::get('twitter_url', '')))
        );
        $meta['twitter_creator'] = $meta['twitter_creator'] ?? static::resolveTwitterHandle(
            SiteSetting::get('twitter_creator', SiteSetting::get('twitter_site', SiteSetting::get('twitter_handle', '')))
        );
        $meta['theme_color'] = $meta['theme_color'] ?? SiteSetting::get('theme_color', '#0f766e');

        $metaNoindex = (bool) ($meta['noindex'] ?? false);
        $queryNoindex = static::shouldNoindexForRequest($request);
        $meta['noindex'] = $metaNoindex || $queryNoindex;
        $meta['robots'] = $meta['noindex'] ? 'noindex, follow' : 'index, follow';

        return $meta;
    }

    public static function shouldNoindexForRequest(?Request $request = null): bool
    {
        $request ??= request();
        $query = $request->query();

        if (empty($query)) {
            return false;
        }

        foreach (array_keys($query) as $key) {
            $normalized = Str::lower((string) $key);
            if (in_array($normalized, ['page', 'buscar', 'marca', 'disponible', 'gclid', 'fbclid'], true)) {
                return true;
            }
            if (Str::startsWith($normalized, 'utm_')) {
                return true;
            }
        }

        return false;
    }

    public static function canonicalForCurrentRequest(): string
    {
        return static::canonicalForRequest(request());
    }

    public static function canonicalForRequest(?Request $request = null): string
    {
        $request ??= request();
        $path = '/'.ltrim($request->path(), '/');
        if ($path === '/index.php' || $request->is('/')) {
            $path = '/';
        }

        return static::hostUrl().($path === '/' ? '/' : $path);
    }

    public static function localBusinessSchema(): array
    {
        $settings = SiteSetting::getAll();
        $name = $settings['site_name'] ?? 'Optica Andina';
        $phone = $settings['phone'] ?? '';
        $address = $settings['address'] ?? 'Tumbaco, Pichincha, Ecuador';
        $email = $settings['email'] ?? '';
        $appUrl = static::hostUrl();

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Optician',
            '@id' => $appUrl.'/#business',
            'name' => $name,
            'url' => $appUrl,
            'description' => $settings['seo_description'] ?? static::defaultMetaDescription(),
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
            'paymentAccepted' => 'Cash, Credit Card',
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Tumbaco'],
                ['@type' => 'City', 'name' => 'Cumbaya'],
                ['@type' => 'City', 'name' => 'Quito'],
            ],
        ];

        if ($phone) {
            $schema['telephone'] = $phone;
        }

        if ($email) {
            $schema['email'] = $email;
        }

        $logoUrl = static::siteLogoUrl();
        if ($logoUrl) {
            $schema['logo'] = [
                '@type' => 'ImageObject',
                'url' => $logoUrl,
            ];
        }

        $sameAs = array_values(array_filter([
            $settings['facebook_url'] ?? null,
            $settings['instagram_url'] ?? null,
            $settings['tiktok_url'] ?? null,
        ]));
        if ($sameAs !== []) {
            $schema['sameAs'] = $sameAs;
        }

        if (! empty($settings['maps_url'])) {
            $schema['hasMap'] = $settings['maps_url'];
        }

        return $schema;
    }

    public static function breadcrumbSchema(array $crumbs): string
    {
        $items = [[
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Inicio',
            'item' => static::hostUrl(),
        ]];

        foreach ($crumbs as $i => $crumb) {
            $item = [
                '@type' => 'ListItem',
                'position' => $i + 2,
                'name' => $crumb['name'],
            ];
            if (! empty($crumb['url'])) {
                $item['item'] = static::normalizeCanonicalToPreferredHost((string) $crumb['url']);
            }
            $items[] = $item;
        }

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public static function websiteSchema(): string
    {
        $url = static::hostUrl();
        $name = SiteSetting::get('site_name', 'Optica Andina');

        return json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => $url.'/#website',
            'url' => $url,
            'name' => $name,
            'publisher' => ['@id' => $url.'/#business'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $url.'/catalogo?buscar={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public static function collectionPageSchema(string $name, string $url, array $items = [], ?string $description = null): string
    {
        $normalizedItems = [];
        foreach (array_values($items) as $index => $item) {
            $itemUrl = Arr::get($item, 'url');
            if (! $itemUrl) {
                continue;
            }

            $listItem = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'url' => static::normalizeCanonicalToPreferredHost((string) $itemUrl),
                'name' => (string) Arr::get($item, 'name', 'Elemento'),
            ];

            if ($image = Arr::get($item, 'image')) {
                $listItem['image'] = $image;
            }

            $normalizedItems[] = $listItem;
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => static::normalizeCanonicalToPreferredHost($url).'#collection',
            'name' => $name,
            'url' => static::normalizeCanonicalToPreferredHost($url),
            'isPartOf' => ['@id' => static::hostUrl().'/#website'],
            'mainEntity' => [
                '@type' => 'ItemList',
                'numberOfItems' => count($normalizedItems),
                'itemListElement' => $normalizedItems,
            ],
        ];

        if ($description) {
            $schema['description'] = $description;
        }

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    public static function hostUrl(): string
    {
        return rtrim((string) config('app.url', url('/')), '/');
    }

    private static function normalizeCanonicalToPreferredHost(string $url): string
    {
        $url = trim($url);
        if ($url === '') {
            return static::canonicalForCurrentRequest();
        }

        if (! Str::startsWith($url, ['http://', 'https://'])) {
            $url = '/'.ltrim($url, '/');
            return static::hostUrl().($url === '/' ? '/' : $url);
        }

        $preferred = parse_url(static::hostUrl());
        $parts = parse_url($url);
        if (! $parts || ! $preferred) {
            return $url;
        }

        $scheme = $preferred['scheme'] ?? ($parts['scheme'] ?? 'https');
        $host = $preferred['host'] ?? ($parts['host'] ?? null);
        $port = $preferred['port'] ?? null;
        $path = $parts['path'] ?? '/';

        $normalized = $scheme.'://'.$host;
        if ($port) {
            $normalized .= ':'.$port;
        }
        $normalized .= $path;

        return $normalized;
    }

    private static function defaultMetaDescription(): string
    {
        return trim((string) SiteSetting::get(
            'seo_description',
            'Optica Andina en Tumbaco, Quito: servicios de salud visual, monturas y lentes.'
        ));
    }

    private static function resolveTwitterHandle(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (Str::contains($value, 'twitter.com/')) {
            $parts = parse_url($value);
            $path = trim((string) ($parts['path'] ?? ''), '/');
            if ($path !== '') {
                $value = '@'.Str::before($path, '/');
            }
        }

        if (! Str::startsWith($value, '@')) {
            $value = '@'.$value;
        }

        return $value;
    }

    private static function siteLogoUrl(): ?string
    {
        $settingsLogo = SiteSetting::get('logo_header', '');
        if ($settingsLogo) {
            return MediaUrl::image($settingsLogo);
        }

        if (file_exists(public_path('images/brand/logo-full.svg'))) {
            return asset('images/brand/logo-full.svg');
        }

        return null;
    }
}
