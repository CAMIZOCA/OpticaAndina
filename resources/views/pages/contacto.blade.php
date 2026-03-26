@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Contáctanos</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Estamos en Tumbaco, Ecuador. Escríbenos o visítanos.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">

            {{-- Información de contacto --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h2>

                <div class="space-y-5">
                    @php
                        $address  = \App\Models\SiteSetting::get('address', 'Av. Interoceánica, Tumbaco, Ecuador');
                        $phone    = \App\Models\SiteSetting::get('phone', '');
                        $whatsapp = \App\Models\SiteSetting::get('whatsapp_number', '');
                        $email    = \App\Models\SiteSetting::get('email', '');
                        $hours    = \App\Models\SiteSetting::get('hours', 'Lun-Vie 9:00-18:00 / Sab 9:00-14:00');
                        $mapsUrl  = \App\Models\SiteSetting::get('maps_url', '');
                        $mapsEmbed = \App\Models\SiteSetting::get('maps_embed', '');
                    @endphp

                    @if($address)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Dirección</p>
                                <p class="text-text-muted">{{ $address }}</p>
                            </div>
                        </div>
                    @endif

                    @if($phone)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Teléfono</p>
                                <a href="tel:{{ $phone }}" class="text-brand-600 hover:underline">{{ $phone }}</a>
                            </div>
                        </div>
                    @endif

                    @if($whatsapp)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-accent-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-accent-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}"
                                   target="_blank" rel="noopener"
                                   data-track-event="whatsapp_click"
                                   data-track-category="conversion"
                                   data-track-label="WhatsApp Contacto"
                                   data-track-location="contact_page"
                                   data-track-destination="whatsapp"
                                   class="text-accent-600 hover:underline">{{ $whatsapp }}</a>
                            </div>
                        </div>
                    @endif

                    @if($email)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Email</p>
                                <a href="mailto:{{ $email }}" class="text-brand-600 hover:underline">{{ $email }}</a>
                            </div>
                        </div>
                    @endif

                    @if($hours)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-brand-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Horario de Atención</p>
                                <p class="text-text-muted">{{ $hours }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Google Maps embed --}}
                <div class="mt-8 rounded-xl overflow-hidden border border-gray-200 h-56">
                    @if($mapsEmbed)
                        {!! $mapsEmbed !!}
                    @elseif($mapsUrl)
                        <div class="h-full flex items-center justify-center bg-gray-50 text-center p-6">
                            <div>
                                <p class="font-semibold text-gray-900 mb-2">Abrir ubicacion en Google Maps</p>
                                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="text-brand-600 hover:underline">
                                    Ver mapa
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Formulario --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h2>

                @if(session('success'))
                    <div class="bg-accent-50 border border-accent-200 text-accent-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contacto.store') }}" method="POST" class="space-y-5">
                    @csrf
                    {{-- Honeypot anti-spam: oculto para humanos, visible para bots --}}
                    <div style="display:none" aria-hidden="true">
                        <label for="website">No rellenar</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('name') border-red-400 @enderror"
                               placeholder="Tu nombre completo">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('email') border-red-400 @enderror"
                               placeholder="tu@email.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                   placeholder="0991234567">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                            <input type="text" id="subject" name="subject"
                                   value="{{ old('subject') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                                   placeholder="Motivo de contacto">
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                            Mensaje <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('message') border-red-400 @enderror"
                                  placeholder="¿En qué podemos ayudarte?">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            data-track-event="primary_cta_click"
                            data-track-category="conversion"
                            data-track-label="Enviar mensaje"
                            data-track-location="contact_form"
                            data-track-destination="contact_form"
                            class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

