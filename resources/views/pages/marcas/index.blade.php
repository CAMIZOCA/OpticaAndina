@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Marcas</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Las mejores marcas de monturas y lentes en Óptica Vista Andina, Tumbaco.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($brands->isEmpty())
            <p class="text-center text-text-muted">No hay marcas disponibles.</p>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($brands as $brand)
                    <a href="{{ route('marcas.show', $brand->slug) }}"
                       class="group bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition border border-gray-100 hover:border-brand-200">
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}"
                                 class="h-16 object-contain mx-auto mb-3 grayscale group-hover:grayscale-0 transition">
                        @else
                            <div class="h-16 flex items-center justify-center mb-3">
                                <span class="text-2xl font-bold text-gray-300 group-hover:text-brand-500 transition">{{ strtoupper(substr($brand->name, 0, 2)) }}</span>
                            </div>
                        @endif
                        <p class="font-semibold text-gray-700 group-hover:text-brand-600 transition text-sm">{{ $brand->name }}</p>
                        @if(isset($brand->products_count) && $brand->products_count > 0)
                            <p class="text-xs text-text-muted mt-1">{{ $brand->products_count }} productos</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

