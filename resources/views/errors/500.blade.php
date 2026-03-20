@php $seo = ['title' => 'Error del servidor – ' . config('app.name'), 'noindex' => true]; @endphp
@extends('layouts.app')

@section('content')
<section class="py-24 text-center">
    <div class="container mx-auto px-4 max-w-xl">
        <p class="text-8xl font-bold text-brand-200 mb-4">500</p>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Error del servidor</h1>
        <p class="text-text-muted mb-8">
            Algo salió mal de nuestro lado. Por favor intenta de nuevo en unos momentos.
        </p>
        <a href="{{ url('/') }}"
           class="inline-block bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-6 rounded-lg transition">
            Volver al inicio
        </a>
    </div>
</section>
@endsection
