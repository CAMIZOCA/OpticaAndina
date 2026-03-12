@props(['service'])
<article class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start gap-4">
        @if($service->icon)
            <div class="flex-shrink-0 w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center text-teal-600">
                <x-dynamic-component :component="$service->icon" class="w-6 h-6" />
            </div>
        @endif
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $service->title }}</h3>
            @if($service->excerpt)
                <p class="text-gray-600 text-sm line-clamp-2">{{ $service->excerpt }}</p>
            @endif
            <a href="{{ route('servicios.show', $service->slug) }}"
               class="inline-flex items-center gap-1 text-teal-600 hover:text-teal-700 font-medium text-sm mt-3 transition-colors">
                Más información
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</article>
