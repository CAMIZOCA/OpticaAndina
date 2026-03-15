@props([
    'title', 'metaDescription' => '', 'ogTitle' => '', 'ogDescription' => '',
    'ogImage' => null, 'ogType' => 'website', 'canonical' => null, 'noindex' => false,
    'schema' => null, 'faqSchema' => null, 'breadcrumbSchema' => null,
    'extraSchema' => null, 'siteName' => '',
])
<title>{{ $title }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow">
@endif
@if($canonical)
<link rel="canonical" href="{{ $canonical }}">
@endif

{{-- Open Graph --}}
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $ogTitle ?: $title }}">
<meta property="og:description" content="{{ $ogDescription ?: $metaDescription }}">
@if($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
@endif
<meta property="og:url" content="{{ url()->current() }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $ogTitle ?: $title }}">
<meta name="twitter:description" content="{{ $ogDescription ?: $metaDescription }}">
@if($ogImage)
<meta name="twitter:image" content="{{ $ogImage }}">
@endif

{{-- Schema.org JSON-LD --}}
@if($schema)
<script type="application/ld+json">{!! $schema !!}</script>
@endif
@if($faqSchema)
<script type="application/ld+json">{!! $faqSchema !!}</script>
@endif
@if($breadcrumbSchema)
<script type="application/ld+json">{!! $breadcrumbSchema !!}</script>
@endif
@if($extraSchema)
<script type="application/ld+json">{!! $extraSchema !!}</script>
@endif
