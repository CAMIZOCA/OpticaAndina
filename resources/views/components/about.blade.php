@props(['title', 'content', 'features' => [], 'cta_text' => 'Agendar cita', 'cta_link', 'image' => null])

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title mb-6">{{ $title }}</h2>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    {{ $content }}
                </p>

                @if($features)
                <ul class="space-y-3 mb-8">
                    @foreach($features as $feature)
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-brand-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-700">{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                <a href="{{ $cta_link }}" class="inline-block bg-brand-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-brand-700 transition"
                   data-track-event="primary_cta_click"
                   data-track-category="conversion"
                   data-track-label="{{ $cta_text }}"
                   data-track-location="home_about"
                   data-track-destination="{{ $cta_link }}">
                    {{ $cta_text }}
                </a>
            </div>

            @if($image)
                <div class="rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-96 object-cover">
                </div>
            @else
                <div class="bg-gray-100 rounded-lg h-96 flex items-center justify-center">
                    <svg class="w-24 h-24 text-brand-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                    </svg>
                </div>
            @endif
        </div>
    </div>
</section>

