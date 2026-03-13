@props(['title' => 'Nos avala nuestra experiencia', 'stats'])

<section class="py-16 bg-brand-900 text-white">
    <div class="container mx-auto px-4">
        @if($title)
        <h2 class="section-title text-center text-white mb-12">{{ $title }}</h2>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($stats as $stat)
            <div class="text-center">
                @if($stat->icon)
                <div class="mb-4">
                    <i class="{{ $stat->icon }} text-4xl text-brand-300"></i>
                </div>
                @endif
                <p class="text-4xl font-bold text-brand-300 mb-2">{{ $stat->value }}</p>
                <p class="text-brand-50">{{ $stat->label }}</p>
            </div>
            @empty
            <div class="col-span-full text-center text-brand-200">
                No hay estadísticas disponibles
            </div>
            @endforelse
        </div>
    </div>
</section>

