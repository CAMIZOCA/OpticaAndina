@props(['title' => 'Nuestro Proceso', 'steps' => []])

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center mb-12">{{ $title }}</h2>

        <div class="grid md:grid-cols-4 gap-6">
            @php
                $defaultSteps = [
                    ['icon' => 'fas fa-calendar', 'title' => 'Agendar Cita', 'text' => 'Reserva tu cita en línea o por WhatsApp'],
                    ['icon' => 'fas fa-eye', 'title' => 'Examen Visual', 'text' => 'Evaluación completa con tecnología moderna'],
                    ['icon' => 'fas fa-glasses', 'title' => 'Soluciones', 'text' => 'Recomendaciones personalizadas y opciones'],
                    ['icon' => 'fas fa-check-circle', 'title' => 'Seguimiento', 'text' => 'Cuidado continuado de tu visión'],
                ];
                $steps = empty($steps) ? $defaultSteps : $steps;
            @endphp

            @foreach($steps as $index => $step)
            <div class="text-center">
                <div class="mb-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-brand-600 text-white rounded-full">
                        <i class="{{ $step['icon'] ?? 'fas fa-check' }} text-2xl"></i>
                    </div>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $step['text'] }}</p>

                @if($index < count($steps) - 1)
                <div class="hidden md:block absolute mt-8 ml-8 text-brand-300 text-2xl">→</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

