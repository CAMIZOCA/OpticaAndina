@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
    <div class="container mx-auto px-4 py-3">
        <ol class="flex items-center gap-2 text-sm text-text-muted">
            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Inicio</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('servicios') }}" class="hover:text-brand-600">Servicios</a></li>
            <li><span>/</span></li>
            <li class="text-gray-800 font-medium truncate">{{ $service->title }}</li>
        </ol>
    </div>
</nav>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            {{-- Cabecera --}}
            <div class="mb-8">
                @if($service->icon)
                    <div class="w-16 h-16 bg-brand-100 rounded-full flex items-center justify-center mb-4">
                        <x-dynamic-component :component="$service->icon" class="w-10 h-10 text-brand-600" />
                    </div>
                @endif
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $service->title }}</h1>
                @if($service->excerpt)
                    <p class="text-xl text-text-muted">{{ $service->excerpt }}</p>
                @endif
            </div>

            {{-- Imagen principal --}}
            @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                     class="w-full h-72 object-cover rounded-2xl mb-8">
            @endif

            {{-- Contenido --}}
            @if($service->content)
                <div class="prose prose-lg prose-teal max-w-none mb-10">
                    {!! $service->content !!}
                </div>
            @endif

            {{-- CTA WhatsApp --}}
            <div class="bg-brand-50 border border-brand-100 rounded-xl p-6 mb-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">¿Quieres agendar este servicio?</h3>
                    <p class="text-text-muted text-sm">Escríbenos por WhatsApp y te atendemos de inmediato.</p>
                </div>
                <x-whatsapp-button
                    :message="$service->cta_whatsapp_text ?? 'Hola, quisiera información sobre el servicio: ' . $service->title"
                    label="Consultar por WhatsApp"
                />
            </div>

            {{-- FAQs --}}
            @if($service->faqs && count($service->faqs) > 0)
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Preguntas Frecuentes</h2>
                    <div class="space-y-4">
                        @foreach($service->faqs as $faq)
                            <details class="bg-white border border-gray-200 rounded-xl p-5" x-data="{ open: false }">
                                <summary class="flex justify-between items-center cursor-pointer font-semibold text-gray-800 list-none"
                                         @click="open = !open">
                                    <span>{{ $faq['question'] }}</span>
                                    <svg class="w-5 h-5 text-brand-600 transition-transform flex-shrink-0 ml-4"
                                         :class="open ? 'rotate-180' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </summary>
                                <p class="mt-3 text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Servicios relacionados --}}
@if(isset($related) && $related->isNotEmpty())
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Otros Servicios</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($related as $rel)
                <x-service-card :service="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

