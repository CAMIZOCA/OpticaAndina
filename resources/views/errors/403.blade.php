@php $seo = ['title' => 'Acceso denegado – ' . config('app.name'), 'noindex' => true]; @endphp
@extends('layouts.app')

@section('content')
<section class="py-24 text-center">
    <div class="container mx-auto px-4 max-w-xl">
        <p class="text-8xl font-bold text-brand-200 mb-4">403</p>
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Acceso denegado</h1>
        <p class="text-text-muted mb-8">
            No tienes permiso para ver esta página.
        </p>
        <a href="{{ url('/') }}"
           class="inline-block bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-6 rounded-lg transition">
            Volver al inicio
        </a>
    </div>
</section>
@endsection
