@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Sobre Nosotros</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Conoce la historia de Óptica Vista Andina y nuestro compromiso con la salud visual.
        </p>
    </div>
</section>

{{-- Historia --}}
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="section-title">Nuestra Historia</h2>
                @foreach($historia as $parrafo)
                    @if($parrafo)
                        <p class="text-gray-600 mb-4">{{ $parrafo }}</p>
                    @endif
                @endforeach
            </div>
            <div class="rounded-2xl overflow-hidden shadow-lg">
                @if($nosotrosImageUrl)
                    <img src="{{ $nosotrosImageUrl }}"
                         alt="Óptica Vista Andina"
                         class="w-full h-72 object-cover">
                @else
                    <div class="bg-brand-50 h-72 flex items-center justify-center">
                        <svg class="w-32 h-32 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Valores --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Nuestros Valores</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">
            @foreach([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Calidad', 'desc' => 'Productos y servicios que cumplen los más altos estándares.'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Compromiso', 'desc' => 'Dedicados a la salud visual de cada paciente.'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Familia', 'desc' => 'Atención cálida y personalizada para toda la familia.'],
                ['icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z', 'title' => 'Tecnología', 'desc' => 'Equipos modernos para diagnósticos precisos.'],
            ] as $valor)
                <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                    <div class="w-14 h-14 bg-brand-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $valor['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $valor['title'] }}</h3>
                    <p class="text-text-muted text-sm">{{ $valor['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Equipo --}}
<section class="py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="section-title">Nuestro Equipo</h2>
        <p class="text-text-muted mb-10">Profesionales comprometidos con tu salud visual</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-3xl mx-auto">
            @foreach($team as $member)
                <div class="text-center">
                    @if(!empty($member['photo']))
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member['photo']) }}"
                             alt="{{ $member['name'] }}"
                             class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-brand-100">
                    @else
                        <div class="w-24 h-24 bg-brand-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-12 h-12 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="font-semibold text-gray-800">{{ $member['name'] }}</h3>
                    <p class="text-text-muted text-sm">{{ $member['role'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-12 section-cta-contrast text-center">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-4">Visítanos en Tumbaco</h2>
        <p class="cta-subtitle mb-6">{{ \App\Models\SiteSetting::get('address', 'Av. Interoceánica, Tumbaco, Ecuador') }}</p>
        <a href="{{ route('contacto') }}" class="inline-block bg-white text-brand-700 font-semibold px-6 py-3 rounded-lg hover:bg-brand-50 transition">
            Contáctanos
        </a>
    </div>
</section>
@endsection
