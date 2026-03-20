@php $seo = ['title' => 'Página no encontrada – ' . config('app.name'), 'noindex' => true]; @endphp
@extends('layouts.app')

@section('content')
<section class="py-24 text-center">
    <div class="container mx-auto px-4 max-w-xl">
        <p class="text-8xl font-bold text-brand-200 mb-4">404</p>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Página no encontrada</h1>
        <p class="text-text-muted mb-8">
            Lo sentimos, la página que buscas no existe o fue movida.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}"
               class="inline-block bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                Volver al inicio
            </a>
            <a href="{{ route('catalogo') }}"
               class="inline-block border border-brand-600 text-brand-600 hover:bg-brand-50 font-semibold py-3 px-6 rounded-lg transition">
                Ver catálogo
            </a>
        </div>
    </div>
</section>
@endsection
