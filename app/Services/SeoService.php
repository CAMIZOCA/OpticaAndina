<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\SeoMeta;
use App\Models\BlogPost;
use App\Models\Product;
use App\Models\Service;

class SeoService
{
    public static function forPage(string $pageKey): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Vista Andina');
        $meta = SeoMeta::getForPage($pageKey);

        return [
            'title'            => $meta?->title ?? $siteName,
            'meta_description' => $meta?->meta_description ?? SiteSetting::get('seo_description', ''),
            'og_title'         => $meta?->og_title ?? $meta?->title ?? $siteName,
            'og_description'   => $meta?->og_description ?? $meta?->meta_description ?? '',
            'og_image'         => $meta?->og_image ?? SiteSetting::get('og_image', ''),
            'canonical'        => $meta?->canonical,
            'noindex'          => $meta?->noindex ?? false,
            'schema'           => null,
            'site_name'        => $siteName,
        ];
    }

    public static function forProduct(Product $product): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Vista Andina');

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Product',
            'name'        => $product->name,
            'description' => strip_tags($product->short_description ?? ''),
            'brand'       => $product->brand ? ['@type' => 'Brand', 'name' => $product->brand->name] : null,
            'offers'      => [
                '@type'       => 'Offer',
                'availability' => $product->is_available
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'priceCurrency' => 'USD',
            ],
        ];

        if ($product->coverImage) {
            $schema['image'] = asset('storage/' . $product->coverImage->path);
        }

        return [
            'title'            => $product->meta_title ?? $product->name . ' – ' . $siteName,
            'meta_description' => $product->meta_description ?? $product->short_description ?? '',
            'og_title'         => $product->meta_title ?? $product->name,
            'og_description'   => $product->short_description ?? '',
            'og_image'         => $product->coverImage ? asset('storage/' . $product->coverImage->path) : SiteSetting::get('og_image', ''),
            'canonical'        => null,
            'noindex'          => false,
            'schema'           => json_encode($schema, JSON_UNESCAPED_UNICODE),
            'site_name'        => $siteName,
        ];
    }

    public static function forService(Service $service): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Vista Andina');

        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $service->title,
            'description' => strip_tags($service->excerpt ?? ''),
            'provider'    => [
                '@type' => 'LocalBusiness',
                'name'  => $siteName,
            ],
        ];

        if ($service->faqs) {
            $faqSchema = [
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => array_map(fn ($faq) => [
                    '@type'          => 'Question',
                    'name'           => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $faq['answer'],
                    ],
                ], $service->faqs),
            ];
        }

        return [
            'title'            => $service->meta_title ?? $service->title . ' – ' . $siteName,
            'meta_description' => $service->meta_description ?? strip_tags($service->excerpt ?? ''),
            'og_title'         => $service->title,
            'og_description'   => strip_tags($service->excerpt ?? ''),
            'og_image'         => $service->image ? asset('storage/' . $service->image) : SiteSetting::get('og_image', ''),
            'canonical'        => null,
            'noindex'          => false,
            'schema'           => json_encode($schema, JSON_UNESCAPED_UNICODE),
            'faq_schema'       => isset($faqSchema) ? json_encode($faqSchema, JSON_UNESCAPED_UNICODE) : null,
            'site_name'        => $siteName,
        ];
    }

    public static function forBlogPost(BlogPost $post): array
    {
        $siteName = SiteSetting::get('site_name', 'Óptica Vista Andina');

        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => 'Article',
            'headline'         => $post->title,
            'description'      => strip_tags($post->excerpt ?? ''),
            'datePublished'    => $post->published_at?->toIso8601String(),
            'dateModified'     => $post->updated_at->toIso8601String(),
            'author'           => ['@type' => 'Organization', 'name' => $siteName],
            'publisher'        => ['@type' => 'Organization', 'name' => $siteName],
        ];

        if ($post->image) {
            $schema['image'] = asset('storage/' . $post->image);
        }

        return [
            'title'            => $post->meta_title ?? $post->title . ' – ' . $siteName,
            'meta_description' => $post->meta_description ?? strip_tags($post->excerpt ?? ''),
            'og_title'         => $post->title,
            'og_description'   => strip_tags($post->excerpt ?? ''),
            'og_image'         => $post->image ? asset('storage/' . $post->image) : SiteSetting::get('og_image', ''),
            'canonical'        => null,
            'noindex'          => false,
            'schema'           => json_encode($schema, JSON_UNESCAPED_UNICODE),
            'site_name'        => $siteName,
        ];
    }

    public static function localBusinessSchema(): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'Optician',
            'name'            => SiteSetting::get('site_name', 'Óptica Vista Andina'),
            'description'     => SiteSetting::get('seo_description', ''),
            'address'         => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => SiteSetting::get('address', 'Tumbaco'),
                'addressLocality' => 'Tumbaco',
                'addressRegion'   => 'Pichincha',
                'addressCountry'  => 'EC',
            ],
            'telephone'       => SiteSetting::get('phone', ''),
            'openingHours'    => 'Mo-Fr 09:00-18:00 Sa 09:00-14:00',
            'url'             => config('app.url'),
        ];
    }
}
