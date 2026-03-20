<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $defaultOgImage   = file_exists(public_path('images/brand/logo-full.svg')) ? asset('images/brand/logo-full.svg') : '';
        $trackingSettings = \App\Models\SiteSetting::getAll();
    @endphp

    {{-- Verification meta tags --}}
    @if(!empty($trackingSettings['google_search_console']))
    <meta name="google-site-verification" content="{{ $trackingSettings['google_search_console'] }}">
    @endif
    @if(!empty($trackingSettings['bing_site_auth']))
    <meta name="msvalidate.01" content="{{ $trackingSettings['bing_site_auth'] }}">
    @endif

    <x-seo-meta
        :title="$seo['title'] ?? config('app.name')"
        :meta-description="$seo['meta_description'] ?? ''"
        :og-title="$seo['og_title'] ?? ''"
        :og-description="$seo['og_description'] ?? ''"
        :og-image="$seo['og_image'] ?: $defaultOgImage"
        :og-type="$seo['og_type'] ?? 'website'"
        :canonical="$seo['canonical'] ?? null"
        :noindex="$seo['noindex'] ?? false"
        :schema="$seo['schema'] ?? null"
        :faq-schema="$seo['faq_schema'] ?? null"
        :breadcrumb-schema="$seo['breadcrumb_schema'] ?? null"
        :extra-schema="$seo['extra_schema'] ?? null"
        :site-name="$seo['site_name'] ?? config('app.name')"
    />

    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="https://fonts.bunny.net/css?family=poppins:500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:500,600,700&display=swap" rel="stylesheet">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    @if(!empty($trackingSettings['google_analytics']))
    <script>
        window.addEventListener('load', function() {
            var s = document.createElement('script');
            s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $trackingSettings['google_analytics'] }}';
            s.async = true;
            document.head.appendChild(s);
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $trackingSettings['google_analytics'] }}');
        });
    </script>
    @endif

    @if(!empty($trackingSettings['microsoft_clarity']))
    <script>
        (function(c,l,a,r,i,t,y){c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window,document,"clarity","script","{{ $trackingSettings['microsoft_clarity'] }}");
    </script>
    @endif

    @if(!empty($trackingSettings['custom_head_scripts']))
    {!! $trackingSettings['custom_head_scripts'] !!}
    @endif
</head>
<body class="bg-white text-text-primary">

    {{-- Skip navigation for keyboard/screen reader users --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-brand-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-lg focus:font-semibold">
        Saltar al contenido principal
    </a>

    @include('components.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

    <x-whatsapp-button :floating="true" label="WhatsApp" />

    @livewireScripts
    <script>
        document.addEventListener('alpine:init', () => {});
    </script>
</body>
</html>