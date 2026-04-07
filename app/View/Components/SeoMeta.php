<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SeoMeta extends Component
{
    public function __construct(
        public string $title = '',
        public string $metaDescription = '',
        public string $ogTitle = '',
        public string $ogDescription = '',
        public string $ogImage = '',
        public string $ogType = 'website',
        public string $ogLocale = 'es_EC',
        public ?string $twitterSite = null,
        public ?string $twitterCreator = null,
        public ?string $themeColor = null,
        public ?string $canonical = null,
        public bool $noindex = false,
        public string $robots = 'index, follow',
        public ?string $schema = null,
        public ?string $faqSchema = null,
        public string $siteName = '',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.seo-meta');
    }
}
