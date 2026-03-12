@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-teal-700 to-teal-900 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Catálogo de Productos</h1>
        <p class="text-teal-100 text-lg max-w-2xl mx-auto">
            Monturas, lentes de contacto y accesorios para toda la familia.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($categories->isEmpty())
            <p class="text-center text-gray-500">No hay categorías disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('catalogo.categoria', $category->slug) }}"
                       class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition border border-gray-100">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-48 bg-teal-50 flex items-center justify-center">
                                <svg class="w-16 h-16 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-5">
                            <h2 class="font-bold text-gray-800 text-xl group-hover:text-teal-600 transition mb-1">{{ $category->name }}</h2>
                            @if($category->description)
                                <p class="text-gray-500 text-sm line-clamp-2">{{ $category->description }}</p>
                            @endif
                            @if(isset($category->products_count))
                                <span class="inline-block mt-3 text-xs bg-teal-100 text-teal-700 px-2 py-1 rounded-full">
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
@endsection
