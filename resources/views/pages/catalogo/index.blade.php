@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Catálogo de Productos</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Monturas, lentes de contacto y accesorios para toda la familia.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($categories->isEmpty())
            <p class="text-center text-text-muted">No hay categorías disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('catalogo.categoria', $category->slug) }}"
                       class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition border border-gray-100">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-brand-50 flex items-center justify-center">
                                <svg class="w-16 h-16 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <h2 class="font-bold text-gray-800 text-xl group-hover:text-brand-600 transition mb-1">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="text-text-muted text-sm line-clamp-2">{{ $category->description }}</p>
                            @endif
                            @if(isset($category->products_count))
                                <span class="inline-block mt-3 text-xs bg-brand-100 text-brand-700 px-2 py-1 rounded-full">
                                    {{ $category->products_count }} productos
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Sección Liquidación --}}
@if($saleProducts->isNotEmpty())
<section class="py-16 bg-red-50 border-t border-red-100">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-3 mb-8">
            <span class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-bold px-4 py-1.5 rounded-full uppercase tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Liquidación
            </span>
            <h2 class="text-2xl font-bold text-gray-900">Productos en Oferta</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($saleProducts as $product)
                <x-product-card :product="$product" :show-sale-badge="true" />
            @endforeach
        </div>
        @if($saleTotalCount > $saleProducts->count())
            <div class="text-center mt-8">
                <p class="text-text-muted text-sm">Mostrando {{ $saleProducts->count() }} de {{ $saleTotalCount }} productos en oferta.</p>
            </div>
        @endif
    </div>
</section>
@endif
@endsection

