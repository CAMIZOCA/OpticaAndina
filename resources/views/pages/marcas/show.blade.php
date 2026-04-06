@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<nav class="bg-gray-50 border-b" aria-label="Breadcrumb">
    <div class="container mx-auto px-4 py-3">
        <ol class="flex items-center gap-2 text-sm text-text-muted">
            <li><a href="{{ route('home') }}" class="hover:text-brand-600">Inicio</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('marcas') }}" class="hover:text-brand-600">Marcas</a></li>
            <li><span>/</span></li>
            <li class="text-gray-800 font-medium">{{ $brand->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-10 border-b bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6">
            @if($brand->logo)
                <img src="{{ \App\Support\MediaUrl::image($brand->logo) }}" alt="{{ $brand->name }}" class="h-20 object-contain">
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $brand->name }}</h1>
                @if($brand->country)
                    <p class="text-text-muted">{{ $brand->country }}</p>
                @endif
                @if($brand->description)
                    <p class="text-gray-600 mt-2 max-w-2xl">{{ $brand->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Bloques de Contenido --}}
@if($brand->content_blocks && count($brand->content_blocks) > 0)
<section class="py-12 border-b bg-gray-50">
    <div class="container mx-auto px-4 space-y-12">
        @foreach($brand->content_blocks as $block)
            @switch($block['type'] ?? '')

                @case('text')
                    <div class="max-w-4xl mx-auto">
                        @if(!empty($block['heading']))
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $block['heading'] }}</h2>
                        @endif
                        <div class="text-gray-700 leading-relaxed [&_p]:mb-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-4 [&_ol]:list-decimal [&_ol]:pl-6 [&_ol]:mb-4 [&_strong]:font-semibold [&_h3]:text-xl [&_h3]:font-bold [&_h3]:mt-6 [&_h3]:mb-3">
                            {!! $block['body'] ?? '' !!}
                        </div>
                    </div>
                @break

                @case('image')
                    <div class="{{ ($block['width'] ?? 'full') === 'half' ? 'max-w-2xl mx-auto' : '' }}">
                        <figure>
                            <img src="{{ \App\Support\MediaUrl::image($block['path'] ?? '') }}"
                                 alt="{{ $block['alt'] ?? '' }}"
                                 class="rounded-2xl w-full object-cover shadow-sm"
                                 loading="lazy">
                            @if(!empty($block['caption']))
                                <figcaption class="text-sm text-text-muted text-center mt-3 italic">
                                    {{ $block['caption'] }}
                                </figcaption>
                            @endif
                        </figure>
                    </div>
                @break

                @case('image_text')
                    <div class="flex flex-col {{ ($block['image_side'] ?? 'left') === 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} gap-8 items-center">
                        <div class="w-full md:w-1/2">
                            <img src="{{ \App\Support\MediaUrl::image($block['image_path'] ?? '') }}"
                                 alt="{{ $block['image_alt'] ?? '' }}"
                                 class="rounded-2xl w-full object-cover shadow-sm"
                                 loading="lazy">
                        </div>
                        <div class="w-full md:w-1/2">
                            @if(!empty($block['heading']))
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $block['heading'] }}</h2>
                            @endif
                            <div class="text-gray-700 leading-relaxed [&_p]:mb-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ul]:mb-4 [&_strong]:font-semibold">
                                {!! $block['body'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                @break

                @case('gallery')
                    @php $cols = (int)($block['columns'] ?? 3); @endphp
                    <div class="grid grid-cols-2 {{ $cols >= 3 ? 'md:grid-cols-3' : '' }} {{ $cols >= 4 ? 'lg:grid-cols-4' : '' }} gap-4">
                        @foreach($block['images'] ?? [] as $img)
                            <div class="overflow-hidden rounded-xl aspect-square bg-gray-100">
                                <img src="{{ \App\Support\MediaUrl::image($img['path'] ?? '') }}"
                                     alt="{{ $img['alt'] ?? '' }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @break

            @endswitch
        @endforeach
    </div>
</section>
@endif

<section class="py-10">
    <div class="container mx-auto px-4">
        @if($products->isEmpty())
            <div class="text-center py-12">
                <p class="text-text-muted">No hay productos disponibles para esta marca.</p>
                <a href="{{ route('catalogo') }}" class="inline-block mt-4 text-brand-600 hover:underline">Ver catálogo completo</a>
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
