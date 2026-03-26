<div class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-2xl">
        <h2 class="section-title text-center mb-2">Agenda tu Cita</h2>
        <p class="text-center text-gray-600 mb-8">Completa el formulario y nos pondremos en contacto contigo para confirmar</p>

        @if($submitted && $successMessage)
        <div class="mb-6 p-4 bg-accent-50 border border-accent-200 rounded-lg">
            <p class="text-accent-800">{{ $successMessage }}</p>
        </div>
        @endif

        @if($errorMessage)
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800">{{ $errorMessage }}</p>
        </div>
        @endif

        <form wire:submit="submit" class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre *
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="Tu nombre"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    />
                    @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email *
                    </label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        placeholder="tu@email.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    />
                    @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                {{-- Teléfono --}}
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                        Teléfono *
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        wire:model="phone"
                        placeholder="+593 9XXXXXXXX"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    />
                    @error('phone')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Servicio --}}
                <div>
                    <label for="service_slug" class="block text-sm font-semibold text-gray-700 mb-2">
                        Servicio *
                    </label>
                    <select
                        id="service_slug"
                        wire:model="service_slug"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    >
                        <option value="">Selecciona un servicio</option>
                        @foreach($services as $service)
                            <option value="{{ $service->slug }}">{{ $service->title }}</option>
                        @endforeach
                    </select>
                    @error('service_slug')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                {{-- Fecha --}}
                <div>
                    <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        Fecha de la Cita *
                    </label>
                    <input
                        type="date"
                        id="appointment_date"
                        wire:model="appointment_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    />
                    @error('appointment_date')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Hora --}}
                <div>
                    <label for="appointment_time" class="block text-sm font-semibold text-gray-700 mb-2">
                        Hora de la Cita *
                    </label>
                    <input
                        type="time"
                        id="appointment_time"
                        wire:model="appointment_time"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition"
                    />
                    @error('appointment_time')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Mensaje --}}
            <div>
                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                    Mensaje (opcional)
                </label>
                <textarea
                    id="message"
                    wire:model="message"
                    placeholder="Cuéntanos si tienes alguna pregunta o comentario..."
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-600 focus:border-transparent outline-none transition resize-none"
                ></textarea>
                @error('message')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botón submit --}}
            <div class="flex items-center gap-4 pt-4">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="flex-1 bg-brand-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-brand-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span wire:loading.remove>Agendar Cita</span>
                    <span wire:loading>
                        <svg class="inline w-5 h-5 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando...
                    </span>
                </button>

                <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_number', '593999000000') }}?text=Hola%2C%20quiero%20agendar%20mi%20cita%20de%20examen%20visual"
                   data-track-event="whatsapp_click"
                   data-track-category="conversion"
                   data-track-label="WhatsApp Citas"
                   data-track-location="appointment_form"
                   data-track-destination="whatsapp"
                   target="_blank"
                   class="bg-accent-500 text-white font-semibold px-6 py-3 rounded-lg hover:bg-accent-600 transition inline-flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.272-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.946 1.254c-1.526.872-2.771 2.07-3.654 3.526-.888 1.456-1.335 3.013-1.326 4.687.01 1.404.192 2.792.56 4.123l.36 1.283-1.582 4.605 4.76-1.53 1.225.72c1.202.712 2.434 1.065 3.74 1.065h.006c2.498 0 4.81-.974 6.55-2.714 1.74-1.74 2.71-4.05 2.71-6.55 0-1.75-.356-3.396-1.056-4.905-.7-1.509-1.706-2.789-2.957-3.798-1.25-.009-2.49-.149-3.708-.42"/>
                    </svg>
                    WhatsApp
                </a>
            </div>

            <p class="text-xs text-text-muted text-center">
                * Campos obligatorios. Nos pondremos en contacto para confirmar tu cita.
            </p>
        </form>
    </div>
</div>

