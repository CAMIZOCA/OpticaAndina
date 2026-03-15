@props(['title' => 'Nuestros Servicios Principales', 'services'])

<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ $title }}</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($services as $service)
            <div class="group overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition">
                <div class="relative h-64 bg-gray-200 overflow-hidden">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             alt="{{ $service->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-brand-100 to-brand-200">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-5xl text-brand-600"></i>
                            @else
                                <svg class="w-24 h-24 text-brand-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"></path>
                                </svg>
                            @endif
                        </div>
                    @endif
                    <div class="absolute inset-0  bg-opacity-0 group-hover:bg-opacity-30 transition"></div>
                </div>

                <div class="p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $service->excerpt ?? Str::limit($service->content, 100) }}</p>
                    <a href="{{ route('servicios.show', $service->slug) }}" class="text-brand-600 font-semibold hover:text-brand-700 transition inline-flex items-center gap-2">
                        Conocer más
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-text-muted py-8">
                No hay servicios disponibles
            </div>
            @endforelse
        </div>
    </div>
</section>

