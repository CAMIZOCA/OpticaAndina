@props(['title' => 'Preguntas Frecuentes', 'faqs'])

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="section-title text-center mb-12">{{ $title }}</h2>

        <div class="space-y-4" x-data="{ open: null }">
            @forelse($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <button 
                    @click="open = (open === {{ $index }}) ? null : {{ $index }}"
                    class="w-full px-6 py-4 text-left font-semibold text-gray-800 hover:bg-gray-50 transition flex items-center justify-between"
                >
                    <span>{{ $faq->question }}</span>
                    <svg 
                        class="w-5 h-5 text-brand-600 transition-transform"
                        :class="{ 'rotate-180': open === {{ $index }} }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>

                <div 
                    x-show="open === {{ $index }}"
                    x-transition
                    class="px-6 py-4 bg-gray-50 text-gray-700 border-t border-gray-200"
                >
                    {!! nl2br(e($faq->answer)) !!}
                </div>
            </div>
            @empty
            <div class="text-center text-text-muted py-8">
                No hay preguntas frecuentes disponibles
            </div>
            @endforelse
        </div>
    </div>
</section>

@pushOnce('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endPushOnce

