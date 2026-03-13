@extends('layouts.app')

@section('content')
<x-hero 
    :title="$hero['title']" 
    :subtitle="$hero['subtitle']"
    :cta_text="$hero['cta_text']"
    :cta_link="$hero['cta_link']"
/>

@if($services->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Nuestros Servicios</h2>
        <p class="text-center text-text-muted mb-10">Atención profesional para toda la familia</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('servicios') }}" class="btn-outline border border-brand-600 text-brand-600 hover:bg-brand-600 hover:text-white px-6 py-3 rounded-lg inline-block transition">
                Ver todos los servicios
            </a>
        </div>
    </div>
</section>
@endif

<x-stats :title="'Nos avala nuestra experiencia'" :stats="$stats" />

<x-about 
    :title="'Cuidado profesional y personalizado'"
    :content="$about['content']"
    :features="$about['features']"
    :cta_link="route('contacto')"
/>

<x-process :title="'Nuestro Proceso'" :steps="$process" />

<livewire:appointment-form />

<x-service-gallery :title="'Nuestros Servicios Principales'" :services="$serviceGallery" />

<x-testimonials :title="'Lo que dicen nuestros pacientes'" :testimonials="$testimonials" />

<x-faq :title="'Preguntas Frecuentes'" :faqs="$faqs" />

@if($video)
<x-video 
    :title="'Conoce nuestras instalaciones'" 
    :video="$video"
    :description="$video->description ?? null"
/>
@endif

@if($featuredProducts->isNotEmpty())
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Productos Destacados</h2>
        <p class="text-center text-text-muted mb-10">Selección especial de nuestro catálogo</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('catalogo') }}" class="btn-outline border border-brand-600 text-brand-600 hover:bg-brand-600 hover:text-white px-6 py-3 rounded-lg inline-block transition">
                Ver catálogo completo
            </a>
        </div>
    </div>
</section>
@endif

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
            <a href="{{ route('marcas') }}" class="text-brand-600 hover:underline font-medium">Ver todas las marcas →</a>
        </div>
    </div>
</section>
@endif

@if($categories->isNotEmpty())
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Explora por Categoría</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-8">
            @foreach($categories as $category)
                <a href="{{ route('catalogo.categoria', $category->slug) }}"
                   class="group relative overflow-hidden rounded-xl bg-brand-50 hover:bg-brand-100 transition p-6 text-center border border-brand-100 hover:border-brand-300">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-16 h-16 object-cover rounded-full mx-auto mb-3">
                    @else
                        <div class="w-16 h-16 bg-brand-200 rounded-full mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                    @endif
                    <h3 class="font-semibold text-gray-800 group-hover:text-brand-700">{{ $category->name }}</h3>
                    @if($category->products_count)
                        <span class="text-sm text-text-muted">{{ $category->products_count }} productos</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($latestPosts->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title text-center">Artículos Recientes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @foreach($latestPosts as $post)
                <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-44 object-cover">
                    @endif
                    <div class="p-5">
                        <p class="text-sm text-text-muted mb-2">{{ $post->published_at?->format('d M Y') }}</p>
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-brand-600 transition">{{ $post->title }}</a>
                        </h3>
                        <p class="text-text-muted text-sm line-clamp-3">{{ $post->excerpt }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-block mt-3 text-brand-600 text-sm font-medium hover:underline">
                            Leer más →
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('blog') }}" class="text-brand-600 hover:underline font-medium">Ver todos los artículos →</a>
        </div>
    </div>
</section>
@endif

<x-cta-final 
    :title="'¿Necesitas una consulta visual?'"
    :subtitle="'Agenda tu examen visual hoy. Estamos en Tumbaco, Ecuador.'"
    :cta_link="route('contacto')"
/>
@endsection


