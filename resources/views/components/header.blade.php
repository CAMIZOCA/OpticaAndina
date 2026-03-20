@php
    $siteName  = \App\Models\SiteSetting::get('site_name', 'Óptica Andina');
    $whatsapp  = \App\Models\SiteSetting::get('whatsapp_number', '593999000000');
    $phone     = \App\Models\SiteSetting::get('phone', '');
    $currentRoute = request()->route()?->getName() ?? '';

    // Logo header: primero desde settings (storage), luego archivos estáticos de fallback
    $logoHeaderPath = \App\Models\SiteSetting::get('logo_header', '');
    $logoHeaderUrl  = $logoHeaderPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($logoHeaderPath) : null;
    $hasFullLogo    = $logoHeaderUrl || file_exists(public_path('images/brand/logo-full.svg'));
    $hasMarkLogo    = file_exists(public_path('images/brand/logo-mark.svg'));
@endphp

<header class="site-header sticky top-0 z-50" x-data="{ open: false }">
    <div class="bg-brand-700 py-1.5 text-sm text-white hidden md:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <span>{{ \App\Models\SiteSetting::get('address', '') }}</span>
            <div class="flex items-center gap-4">
                @if($phone)
                <a href="tel:{{ $phone }}" class="text-white transition-colors hover:text-accent-200">{{ $phone }}</a>
                @endif
                <span>{{ \App\Models\SiteSetting::get('hours', '') }}</span>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-18 items-center justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="Inicio {{ $siteName }}">
                @if($hasMarkLogo)
                <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Isotipo {{ $siteName }}" width="42" height="42" class="h-10 w-10 shrink-0 md:hidden">
                @endif

                @if($logoHeaderUrl)
                <img src="{{ $logoHeaderUrl }}" alt="Logo {{ $siteName }}" height="44" class="hidden h-11 w-auto md:block">
                @elseif($hasFullLogo)
                <img src="{{ asset('images/brand/logo-full.svg') }}" alt="Logo {{ $siteName }}" width="320" height="120" class="hidden h-11 w-auto md:block">
                @else
                <span class="font-display text-2xl font-semibold text-brand-700">{{ $siteName }}</span>
                @endif
            </a>

            <nav class="hidden items-center gap-6 md:flex">
                @php
                $navLinks = [
                    ['route' => 'home',      'label' => 'Inicio'],
                    ['route' => 'nosotros',  'label' => 'Nosotros'],
                    ['route' => 'servicios', 'label' => 'Servicios'],
                    ['route' => 'catalogo',  'label' => 'Catálogo'],
                    ['route' => 'marcas',    'label' => 'Marcas'],
                    ['route' => 'blog',      'label' => 'Blog'],
                    ['route' => 'contacto',  'label' => 'Contacto'],
                ];
                @endphp
                @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="border-b-2 px-1 py-1 text-sm font-medium transition-colors {{ str_starts_with($currentRoute, $link['route']) ? 'border-brand-600 text-brand-700' : 'border-transparent text-text-primary hover:text-brand-600' }}">
                    {{ $link['label'] }}
                </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ $whatsapp }}"
                   target="_blank"
                   rel="noopener"
                   class="btn-secondary hidden px-4 py-2 text-sm sm:inline-flex"
                   aria-label="Escribir por WhatsApp">
                    WhatsApp
                </a>
                <button @click="open = !open" class="rounded-md p-2 text-text-primary hover:text-brand-600 md:hidden" aria-label="Menú">
                    <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-border-soft bg-white md:hidden shadow-sm">
        <nav class="flex flex-col gap-1 px-4 py-3">
            @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               @click="open = false"
               class="rounded-md px-3 py-2 font-medium text-text-primary transition-colors hover:bg-brand-50 hover:text-brand-700">
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>
    </div>
</header>