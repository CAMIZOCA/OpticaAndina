@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
    <div class="container mx-auto px-4 py-3">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-teal-600">Inicio</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('marcas') }}" class="hover:text-teal-600">Marcas</a></li>
            <li><span>/</span></li>
            <li class="text-gray-800 font-medium">{{ $brand->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-10 border-b bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6">
            @if($brand->logo)
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-20 object-contain">
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $brand->name }}</h1>
                @if($brand->country)
                    <p class="text-gray-500">{{ $brand->country }}</p>
                @endif
                @if($brand->description)
                    <p class="text-gray-600 mt-2 max-w-2xl">{{ $brand->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500">No hay productos disponibles para esta marca.</p>
                <a href="{{ route('catalogo') }}" class="inline-block mt-4 text-teal-600 hover:underline">Ver catálogo completo</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
