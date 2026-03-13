<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $defaultOgImage = file_exists(public_path('images/brand/logo-full.svg')) ? asset('images/brand/logo-full.svg') : '';
    @endphp

    <x-seo-meta
        :title="$seo['title'] ?? config('app.name')"
        :meta-description="$seo['meta_description'] ?? ''"
        :og-title="$seo['og_title'] ?? ''"
        :og-description="$seo['og_description'] ?? ''"
        :og-image="$seo['og_image'] ?: $defaultOgImage"
        :canonical="$seo['canonical'] ?? null"
        :noindex="$seo['noindex'] ?? false"
        :schema="$seo['schema'] ?? null"
        :faq-schema="$seo['faq_schema'] ?? null"
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

    @php $gaId = \App\Models\SiteSetting::get('google_analytics') @endphp
    @if($gaId)
    <script>
        window.addEventListener('load', function() {
            var s = document.createElement('script');
            s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $gaId }}';
            s.async = true;
            document.head.appendChild(s);
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
        });
    </script>
    @endif
</head>
<body class="bg-white text-text-primary">

    @include('components.header')

    <main>
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