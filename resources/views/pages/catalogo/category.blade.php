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
            <li class="text-gray-800 font-medium">{{ $category->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-8 section-cta-contrast">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="cta-subtitle">{{ $category->description }}</p>
        @endif
    </div>
</section>

<section class="py-10">
    <div class="container mx-auto px-4">
        @livewire('product-filter', ['category' => $category, 'brands' => $brands])
    </div>
</section>
@endsection

