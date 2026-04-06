@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Marcas</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Las mejores marcas de monturas y lentes en Óptica Andina, Tumbaco.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">

        @if($featuredBrands->isEmpty() && $regularBrands->isEmpty())
            <p class="text-center text-text-muted">No hay marcas disponibles.</p>

        @else

            {{-- Marcas Destacadas --}}
            @if($featuredBrands->isNotEmpty())
            <div class="mb-14">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Nuestras Marcas Propias</h2>
                <p class="text-text-muted mb-8">Marcas diseñadas y distribuidas exclusivamente por Óptica Andina.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    @foreach($featuredBrands as $brand)
                        <a href="{{ route('marcas.show', $brand->slug) }}"
                           class="group relative bg-white rounded-2xl p-8 shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-brand-300 flex flex-col items-center text-center overflow-hidden">

                            {{-- Badge destacada --}}
                            <span class="absolute top-4 right-4 bg-brand-100 text-brand-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                Marca propia
                            </span>

                            @if($brand->logo)
                                <img src="{{ \App\Support\MediaUrl::image($brand->logo) }}" alt="{{ $brand->name }}"
                                     class="h-24 object-contain mb-5 group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="h-24 flex items-center justify-center mb-5">
                                    <span class="text-5xl font-bold text-brand-200 group-hover:text-brand-400 transition">
                                        {{ strtoupper(substr($brand->name, 0, 2)) }}
                                    </span>
                                </div>
                            @endif

                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-brand-600 transition mb-2">
                                {{ $brand->name }}
                            </h3>

                            @if($brand->description)
                                <p class="text-sm text-text-muted leading-relaxed line-clamp-2 mb-3">{{ $brand->description }}</p>
                            @endif

                            @if(isset($brand->products_count) && $brand->products_count > 0)
                                <span class="text-xs text-brand-600 font-medium">{{ $brand->products_count }} productos</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Otras Marcas --}}
            @if($regularBrands->isNotEmpty())
            <div>
                @if($featuredBrands->isNotEmpty())
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Otras Marcas</h2>
                    <p class="text-text-muted mb-8">Selección de marcas internacionales disponibles en nuestra óptica.</p>
                @endif

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach($regularBrands as $brand)
                        <a href="{{ route('marcas.show', $brand->slug) }}"
                           class="group bg-white rounded-xl p-6 text-center shadow-sm hover:shadow-md transition border border-gray-100 hover:border-brand-200">
                            @if($brand->logo)
                                <img src="{{ \App\Support\MediaUrl::image($brand->logo) }}" alt="{{ $brand->name }}"
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
            </div>
            @endif

        @endif
    </div>
</section>
@endsection
