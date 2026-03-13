@props(['title' => 'Agenda tu cita hoy', 'subtitle' => 'Te esperamos en Tumbaco', 'cta_text' => 'Agendar Cita', 'cta_link'])

<section class="py-20 section-cta-contrast">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ $title }}</h2>
        
        @if($subtitle)
        <p class="text-xl cta-subtitle mb-8">{{ $subtitle }}</p>
        @endif

        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ $cta_link }}" class="bg-white text-brand-700 hover:bg-gray-100 font-bold px-8 py-4 rounded-lg transition transform hover:scale-105">
                {{ $cta_text }}
            </a>
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text=Hola%2C%20me%20gustar%C3%ADa%20agendar%20una%20cita%20de%20examen%20visual" target="_blank" class="border-2 border-white text-white hover:bg-white hover:text-brand-700 font-bold px-8 py-4 rounded-lg transition">
                Contactar por WhatsApp
            </a>
        </div>
    </div>
</section>

