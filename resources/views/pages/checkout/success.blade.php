@php $seo = ['title' => 'Pago exitoso – ' . config('app.name'), 'noindex' => true]; @endphp
@extends('layouts.app')

@section('content')
<section class="py-20">
    <div class="container mx-auto px-4 max-w-lg text-center">
        <div class="bg-white rounded-2xl shadow-sm border p-12">
            <div class="w-20 h-20 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-3">¡Pago exitoso!</h1>
            <p class="text-gray-600 mb-8">
                Tu compra fue procesada correctamente. Recibirás un correo de confirmación de Stripe con los detalles del pedido.<br>
                Nos pondremos en contacto contigo pronto para coordinar la entrega.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('catalogo') }}"
                   class="btn-primary inline-flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42-.39-.39-1.02-.39-1.41 0l-6.59 6.59c-.39.39-.39 1.02 0 1.41l6.59 6.59c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1z"/>
                    </svg>
                    Seguir comprando
                </a>
                <a href="{{ route('home') }}" class="btn-outline inline-flex items-center justify-center">
                    Ir al inicio
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
