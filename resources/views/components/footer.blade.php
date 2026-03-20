@php
    $siteName  = \App\Models\SiteSetting::get('site_name', 'Óptica Andina');
    $address   = \App\Models\SiteSetting::get('address', 'Tumbaco, Pichincha, Ecuador');
    $phone     = \App\Models\SiteSetting::get('phone', '');
    $email     = \App\Models\SiteSetting::get('email', '');
    $hours     = \App\Models\SiteSetting::get('hours', '');
    $facebook  = \App\Models\SiteSetting::get('facebook_url', '');
    $instagram = \App\Models\SiteSetting::get('instagram_url', '');

    // Logo footer: primero desde settings (storage), luego archivo estático de fallback
    $logoFooterPath = \App\Models\SiteSetting::get('logo_footer', '');
    $logoFooterUrl  = $logoFooterPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($logoFooterPath) : null;
    $hasMarkLogo    = file_exists(public_path('images/brand/logo-mark.svg'));
@endphp

<footer class="mt-16 bg-brand-800 text-brand-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div>
                <div class="mb-3">
                    @if($logoFooterUrl)
                    <img src="{{ $logoFooterUrl }}" alt="Logo {{ $siteName }}" height="44" class="h-11 w-auto">
                    @elseif($hasMarkLogo)
                    <div class="flex items-center gap-3 text-white">
                        <img src="{{ asset('images/brand/logo-mark.svg') }}" alt="Isotipo {{ $siteName }}" width="42" height="42" class="h-10 w-10 shrink-0">
                        <span class="font-display text-lg font-semibold">{{ $siteName }}</span>
                    </div>
                    @else
                    <span class="font-display text-lg font-semibold text-white">{{ $siteName }}</span>
                    @endif
                </div>
                <p class="mb-4 text-sm text-brand-50/90">Tu visión, nuestra misión. Especialistas en salud visual en Tumbaco, Ecuador.</p>
                <div class="flex gap-3">
                    @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener" class="text-brand-50 transition-colors hover:text-accent-300" aria-label="Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener" class="text-brand-50 transition-colors hover:text-accent-300" aria-label="Instagram">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="mb-3 text-lg font-semibold text-white">Navegación</h3>
                <nav class="flex flex-col gap-2 text-sm">
                    <a href="{{ route('nosotros') }}" class="text-white/80 transition-colors hover:text-white">Nosotros</a>
                    <a href="{{ route('servicios') }}" class="text-white/80 transition-colors hover:text-white">Servicios</a>
                    <a href="{{ route('catalogo') }}" class="text-white/80 transition-colors hover:text-white">Catálogo</a>
                    <a href="{{ route('marcas') }}" class="text-white/80 transition-colors hover:text-white">Marcas</a>
                    <a href="{{ route('blog') }}" class="text-white/80 transition-colors hover:text-white">Blog</a>
                    <a href="{{ route('contacto') }}" class="text-white/80 transition-colors hover:text-white">Contacto</a>
                </nav>
            </div>

            <div>
                <h3 class="mb-3 text-lg font-semibold text-white">Contacto</h3>
                <address class="not-italic text-sm flex flex-col gap-2 text-white/80">
                    @if($address)
                    <span>{{ $address }}</span>
                    @endif
                    @if($phone)
                    <a href="tel:{{ $phone }}" class="text-white/80 transition-colors hover:text-white">{{ $phone }}</a>
                    @endif
                    @if($email)
                    <a href="mailto:{{ $email }}" class="text-white/80 transition-colors hover:text-white">{{ $email }}</a>
                    @endif
                    @if($hours)
                    <span>{{ $hours }}</span>
                    @endif
                </address>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-center justify-between gap-3 border-t border-brand-700 pt-6 text-xs text-brand-200 sm:flex-row">
            <p>© {{ date('Y') }} {{ $siteName }}. Todos los derechos reservados.</p>
            <a href="/sitemap.xml" class="text-brand-200 transition-colors hover:text-white">Sitemap</a>
        </div>
    </div>
</footer>