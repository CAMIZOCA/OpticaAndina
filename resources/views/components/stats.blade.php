@props(['title' => 'Nos avala nuestra experiencia', 'stats'])

<section class="py-16 bg-brand-900 text-white">
    <div class="container mx-auto px-4">
        @if($title)
        <h2 class="section-title text-center text-white mb-12">{{ $title }}</h2>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($stats as $stat)
            @php
                // Parse numeric part and suffix (e.g. "15+" → target=15, suffix="+")
                $rawValue = $stat->value;
                preg_match('/^([\d,]+)(.*)$/', trim($rawValue), $matches);
                $numericStr = isset($matches[1]) ? str_replace(',', '', $matches[1]) : '0';
                $target     = (int) $numericStr;
                $suffix     = $matches[2] ?? '';
                // Detect if the original had comma formatting (thousands)
                $useCommas  = str_contains($rawValue, ',');
            @endphp
            <div
                class="text-center"
                x-data="{
                    display: '{{ $rawValue }}',
                    target: {{ $target }},
                    suffix: '{{ $suffix }}',
                    useCommas: {{ $useCommas ? 'true' : 'false' }},
                    start() {
                        const duration = 1800;
                        const steps = 60;
                        const increment = this.target / steps;
                        let current = 0;
                        const tick = () => {
                            current = Math.min(current + increment, this.target);
                            const rounded = Math.round(current);
                            this.display = (this.useCommas
                                ? rounded.toLocaleString('es-ES')
                                : rounded
                            ) + this.suffix;
                            if (current < this.target) requestAnimationFrame(tick);
                        };
                        requestAnimationFrame(tick);
                    }
                }"
                x-intersect.once="start()"
            >
                @if($stat->icon)
                <div class="mb-4">
                    <i class="{{ $stat->icon }} text-4xl text-brand-300"></i>
                </div>
                @endif
                <p class="text-4xl font-bold text-brand-300 mb-2" x-text="display">{{ $rawValue }}</p>
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
