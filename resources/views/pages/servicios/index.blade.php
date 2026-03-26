@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Nuestros Servicios</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Atención visual integral para toda la familia en Tumbaco, Ecuador.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($services->isEmpty())
            <p class="text-center text-text-muted">No hay servicios disponibles por el momento.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <x-service-card :service="$service" />
                @endforeach
            </div>
        @endif
    </div>
</section>

<section class="py-12 section-cta-contrast text-center">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">¿Tienes alguna pregunta?</h2>
        <p class="cta-subtitle mb-6">Escríbenos por WhatsApp o visítanos en nuestra óptica en Tumbaco.</p>
        <a href="{{ route('contacto') }}" class="inline-block bg-white text-brand-700 font-semibold px-6 py-3 rounded-lg hover:bg-brand-50 transition"
           data-track-event="primary_cta_click"
           data-track-category="conversion"
           data-track-label="Cont?ctanos"
           data-track-location="services_index"
           data-track-destination="{{ route('contacto') }}">
            Contáctanos
        </a>
    </div>
</section>
@endsection

