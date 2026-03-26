@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
    <div class="container mx-auto px-4 py-3">
        <ol class="flex items-center gap-2 text-sm text-text-muted">
            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Inicio</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('catalogo') }}" class="hover:text-brand-600">Catálogo</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('catalogo.categoria', $category->slug) }}" class="hover:text-brand-600">{{ $category->name }}</a></li>
            <li><span>/</span></li>
            <li class="text-gray-800 font-medium truncate">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            {{-- Galería --}}
            <div x-data="{ active: 0 }">
                @if($product->images->isNotEmpty())
                    {{-- Imagen principal --}}
                    <div class="rounded-2xl overflow-hidden bg-gray-50 mb-4">
                        @foreach($product->images as $i => $img)
                            <img x-show="active === {{ $i }}"
                                 src="{{ \App\Support\MediaUrl::image($img->path) }}"
                                 alt="{{ $img->alt ?? $product->name }}"
                                 class="w-full h-96 object-contain">
                        @endforeach
                    </div>
                    {{-- Miniaturas --}}
                    @if($product->images->count() > 1)
                        <div class="flex gap-3 overflow-x-auto">
                            @foreach($product->images as $i => $img)
                                <button @click="active = {{ $i }}"
                                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition"
                                        :class="active === {{ $i }} ? 'border-brand-500' : 'border-transparent hover:border-gray-300'">
                                    <img src="{{ \App\Support\MediaUrl::image($img->path) }}" alt="" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="rounded-2xl bg-gray-100 h-96 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                <div class="mb-2">
                    <a href="{{ route('catalogo.categoria', $category->slug) }}" class="text-sm text-brand-600 hover:underline">
                        {{ $category->name }}
                    </a>
                    @if($product->brand)
                        <span class="text-text-muted mx-2">·</span>
                        <a href="{{ route('marcas.show', $product->brand->slug) }}" class="text-sm text-text-muted hover:text-brand-600">
                            {{ $product->brand->name }}
                        </a>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                @if($product->description)
                    <div class="text-gray-600 mb-6 leading-relaxed">
                        {!! $product->description !!}
                    </div>
                @endif

                {{-- Atributos --}}
                @if($product->attributes && count($product->attributes) > 0)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Características</h3>
                        <dl class="grid grid-cols-2 gap-2">
                            @foreach($product->attributes as $attr)
                                @if(!empty($attr['key']) && !empty($attr['value']))
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <dt class="text-xs text-text-muted uppercase tracking-wide">{{ $attr['key'] }}</dt>
                                        <dd class="font-medium text-gray-800 mt-0.5">{{ $attr['value'] }}</dd>
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                @endif

                {{-- Disponibilidad --}}
                <div class="mb-6">
                    @if($product->is_available)
                        <span class="inline-flex items-center gap-1.5 text-accent-700 bg-accent-50 border border-accent-200 px-3 py-1.5 rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-accent-500 rounded-full"></span>
                            Disponible
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-text-muted bg-gray-100 px-3 py-1.5 rounded-full text-sm">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            Consultar disponibilidad
                        </span>
                    @endif
                </div>

                {{-- CTA Stripe --}}
                @if($stripeEnabled && $product->is_purchasable && $product->price > 0)
                <div class="mb-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm text-text-muted">USD</span>
                    </div>
                    <form method="POST" action="{{ route('checkout', $product->slug) }}">
                        @csrf
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Comprar ahora
                        </button>
                    </form>
                    <p class="text-xs text-text-muted mt-2 text-center">Pago seguro con Stripe · Tarjeta de crédito/débito</p>
                </div>
                @endif

                {{-- CTA WhatsApp --}}
                <div class="bg-accent-50 border border-accent-100 rounded-xl p-5">
                    <p class="text-gray-700 mb-3 font-medium">¿Te interesa este producto?</p>
                    <p class="text-text-muted text-sm mb-4">Consúltanos por WhatsApp para más información, disponibilidad y asesoramiento personalizado.</p>
                    <x-whatsapp-button
                        :message="$product->whatsapp_text ?? 'Hola, me interesa el producto: ' . $product->name"
                        label="Consultar por WhatsApp"
                        event-location="product_detail"
                        class="w-full justify-center"
                    />
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Productos relacionados --}}
@if($related->isNotEmpty())
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title">Productos Relacionados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            @foreach($related as $rel)
                <x-product-card :product="$rel" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
