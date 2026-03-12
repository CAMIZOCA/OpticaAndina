@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle cx="20" cy="20" r="40" fill="currentColor"/>
            <circle cx="80" cy="80" r="30" fill="currentColor"/>
        </svg>
    </div>
    <div class="container mx-auto px-4 py-24 md:py-32 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Tu visión, nuestro compromiso
            </h1>
            <p class="text-xl text-teal-100 mb-8 max-w-2xl">
                Más de 15 años cuidando la salud visual de las familias de Tumbaco. Exámenes visuales, monturas nacionales e importadas, lentes de contacto y mucho más.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('catalogo') }}" class="btn-primary bg-white text-teal-800 hover:bg-teal-50 font-semibold px-6 py-3 rounded-lg transition">
                    Ver Catálogo
                </a>
                <a href="{{ route('servicios') }}" class="btn-outline border-2 border-white text-white hover:bg-white hover:text-teal-800 font-semibold px-6 py-3 rounded-lg transition">
                    Nuestros Servicios
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Servicios destacados --}}
@if($services->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Nuestros Servicios</h2>
        <p class="text-center text-gray-500 mb-10">Atención profesional para toda la familia</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('servicios') }}" class="btn-outline border border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white px-6 py-3 rounded-lg inline-block transition">
                Ver todos los servicios
            </a>
        </div>
    </div>
</section>
@endif

{{-- Productos destacados --}}
@if($featuredProducts->isNotEmpty())
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Productos Destacados</h2>
        <p class="text-center text-gray-500 mb-10">Selección especial de nuestro catálogo</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('catalogo') }}" class="btn-outline border border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white px-6 py-3 rounded-lg inline-block transition">
                Ver catálogo completo
            </a>
        </div>
    </div>
</section>
@endif

{{-- Marcas --}}
@if($brands->isNotEmpty())
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Marcas que Trabajamos</h2>
        <div class="flex flex-wrap justify-center items-center gap-8 mt-8">
            @foreach($brands as $brand)
                <a href="{{ route('marcas.show', $brand->slug) }}" class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100">
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-12 object-contain">
                    @else
                        <span class="text-gray-600 font-semibold text-lg">{{ $brand->name }}</span>
                    @endif
                </a>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('marcas') }}" class="text-teal-600 hover:underline font-medium">Ver todas las marcas →</a>
        </div>
    </div>
</section>
@endif

{{-- Categorías --}}
@if($categories->isNotEmpty())
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Explora por Categoría</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8">
            @foreach($categories as $category)
                <a href="{{ route('catalogo.categoria', $category->slug) }}"
                   class="group relative overflow-hidden rounded-xl bg-teal-50 hover:bg-teal-100 transition p-6 text-center border border-teal-100 hover:border-teal-300">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-16 h-16 object-cover rounded-full mx-auto mb-3">
                    @else
                        <div class="w-16 h-16 bg-teal-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="font-semibold text-gray-800 group-hover:text-teal-700">{{ $category->name }}</h3>
                    @if($category->products_count)
                        <span class="text-sm text-gray-500">{{ $category->products_count }} productos</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Blog reciente --}}
@if($latestPosts->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Artículos Recientes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @foreach($latestPosts as $post)
                <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover">
                    @endif
                    <div class="p-5">
                        <p class="text-sm text-gray-400 mb-2">{{ $post->published_at?->format('d M Y') }}</p>
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-teal-600 transition">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-block mt-3 text-teal-600 text-sm font-medium hover:underline">
                            Leer más →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('blog') }}" class="text-teal-600 hover:underline font-medium">Ver todos los artículos →</a>
        </div>
    </div>
</section>
@endif

{{-- CTA Contacto --}}
<section class="py-16 bg-teal-700 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">¿Necesitas una consulta visual?</h2>
        <p class="text-teal-100 text-lg mb-8 max-w-xl mx-auto">
            Agenda tu examen visual o escríbenos por WhatsApp. Estamos en Tumbaco, Ecuador.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\SiteSetting::get('whatsapp_number', '')) }}?text={{ urlencode(\App\Models\SiteSetting::get('whatsapp_default_message', '¡Hola! Quisiera obtener más información.')) }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                WhatsApp
            </a>
            <a href="{{ route('contacto') }}" class="inline-block border-2 border-white text-white hover:bg-white hover:text-teal-700 font-semibold px-6 py-3 rounded-lg transition">
                Contáctanos
            </a>
        </div>
    </div>
</section>
@endsection
