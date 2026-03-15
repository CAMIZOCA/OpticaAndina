@props(['title', 'subtitle', 'cta_text' => 'Ver Catálogo', 'cta_link', 'badge' => '📍 Tumbaco, Quito', 'image' => null])

<section class="relative overflow-hidden bg-gradient-to-b from-surface-soft to-white">
    {{-- Background decorative shapes (shown only when there's no image) --}}
    @if(!$image)
    <div class="absolute inset-0 opacity-20">
        <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle cx="20" cy="20" r="40" fill="#dce9fa" />
            <circle cx="80" cy="80" r="30" fill="#e7f0cf" />
        </svg>
    </div>
    @endif

    <div class="container relative z-10 mx-auto px-4 py-20 md:py-28">
        <div class="{{ $image ? 'grid grid-cols-1 md:grid-cols-2 gap-10 items-center' : 'max-w-3xl' }}">
            {{-- Text content --}}
            <div>
                @if($badge)
                <div class="mb-4 inline-block rounded-full bg-accent-100 px-4 py-2 text-sm font-semibold text-accent-700">
                    {{ $badge }}
                </div>
                @endif

                <h1 class="mb-4 font-bold leading-tight text-brand-700">
                    {{ $title }}
                </h1>

                <p class="mb-8 max-w-2xl text-xl text-text-muted">
                    {{ $subtitle }}
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ $cta_link }}" class="btn-primary px-6 py-3">
                        {{ $cta_text }}
                    </a>
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text=Hola%2C%20quisiera%20agendar%20una%20cita" target="_blank" class="btn-secondary px-6 py-3">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.946 1.254c-1.526.872-2.771 2.07-3.654 3.526-.888 1.456-1.335 3.013-1.326 4.687.01 1.404.192 2.792.56 4.123l.36 1.283-1.582 4.605 4.76-1.53 1.225.72c1.202.712 2.434 1.065 3.74 1.065h.006c2.498 0 4.81-.974 6.55-2.714 1.74-1.74 2.71-4.05 2.71-6.55 0-1.75-.356-3.396-1.056-4.905-.7-1.509-1.706-2.789-2.957-3.798-1.25-.009-2.49-.149-3.708-.42"/>
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            {{-- Hero image (shown only when $image is provided) --}}
            @if($image)
            <div class="relative hidden md:block">
                <img src="{{ $image }}"
                     alt="{{ $title }}"
                     class="w-full max-h-[480px] object-cover rounded-2xl shadow-xl">
                <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-brand-100 rounded-2xl -z-10"></div>
                <div class="absolute -top-4 -right-4 w-16 h-16 bg-accent-100 rounded-xl -z-10"></div>
            </div>
            @endif
        </div>
    </div>
</section>
