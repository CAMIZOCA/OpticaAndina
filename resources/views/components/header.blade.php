@php
    $siteName = \App\Models\SiteSetting::get('site_name', 'Óptica Vista Andina');
    $whatsapp = \App\Models\SiteSetting::get('whatsapp_number', '593999000000');
    $phone    = \App\Models\SiteSetting::get('phone', '');
    $currentRoute = request()->route()?->getName() ?? '';
@endphp

<header class="bg-white shadow-sm sticky top-0 z-40" x-data="{ open: false }">
    {{-- Top bar --}}
    <div class="bg-teal-700 text-white text-sm py-1.5 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <span>{{ \App\Models\SiteSetting::get('address', '') }}</span>
            <div class="flex items-center gap-4">
                @if($phone)
                <a href="tel:{{ $phone }}" class="hover:text-teal-200 transition-colors">{{ $phone }}</a>
                @endif
                <span>{{ \App\Models\SiteSetting::get('hours', '') }}</span>
            </div>
        </div>
    </div>

    {{-- Main nav --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-teal-700 text-xl">
                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ $siteName }}</span>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-6">
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
                   class="text-gray-600 hover:text-teal-600 font-medium transition-colors {{ str_starts_with($currentRoute, $link['route']) ? 'text-teal-600 border-b-2 border-teal-600' : '' }}">
                    {{ $link['label'] }}
                </a>
                @endforeach
            </nav>

            {{-- CTA + mobile menu button --}}
            <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener"
                   class="hidden sm:inline-flex items-center gap-1.5 bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-3 py-2 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
                <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-600 hover:text-teal-600" aria-label="Menú">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition class="md:hidden border-t border-gray-100 bg-white">
        <nav class="px-4 py-3 flex flex-col gap-1">
            @foreach($navLinks as $link)
            <a href="{{ route($link['route']) }}"
               @click="open = false"
               class="px-3 py-2 rounded-md text-gray-700 hover:bg-teal-50 hover:text-teal-600 font-medium transition-colors">
                {{ $link['label'] }}
            </a>
            @endforeach
        </nav>
    </div>
</header>
