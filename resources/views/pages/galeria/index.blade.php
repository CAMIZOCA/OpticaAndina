@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Galería</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Imágenes de nuestra óptica, productos y servicios en Tumbaco.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">

        @if($media->isEmpty())
            <div class="text-center py-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-text-muted">No hay imágenes disponibles aún.</p>
            </div>
        @else
            {{-- Masonry layout usando CSS columns --}}
            <div class="columns-2 sm:columns-3 lg:columns-4 gap-4">
                @foreach($media as $item)
                    <div class="break-inside-avoid mb-4">
                        <div class="overflow-hidden rounded-xl bg-gray-100 group">
                            <img src="{{ $item->url }}"
                                 alt="{{ $item->alt ?: $item->filename }}"
                                 class="w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                        @if($item->alt)
                            <p class="text-xs text-text-muted mt-1 px-1 line-clamp-1">{{ $item->alt }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            @if($media->hasPages())
                <div class="mt-10">
                    {{ $media->links() }}
                </div>
            @endif
        @endif

    </div>
</section>
@endsection
