<div>
    {{-- Filtros --}}
    <div class="bg-white border border-gray-100 rounded-xl p-5 mb-8 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Búsqueda --}}
            <div class="lg:col-span-2">
                <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Buscar</label>
                <div class="relative">
                    <input type="text"
                           wire:model.live.debounce.400ms="search"
                           placeholder="Buscar producto..."
                           class="w-full border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Marca --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Marca</label>
                <select wire:model.live="brandSlug"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="">Todas las marcas</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Disponibilidad --}}
            <div class="flex items-end">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox"
                           wire:model.live="onlyAvailable"
                           class="w-4 h-4 text-teal-600 rounded border-gray-300 focus:ring-teal-500">
                    <span class="text-sm text-gray-700">Solo disponibles</span>
                </label>
            </div>
        </div>

        {{-- Limpiar filtros --}}
        @if($search || $brandSlug || $onlyAvailable)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <button wire:click="$set('search', ''); $set('brandSlug', null); $set('onlyAvailable', false)"
                        class="text-sm text-teal-600 hover:underline">
                    × Limpiar filtros
                </button>
            </div>
        @endif
    </div>

    {{-- Loading --}}
    <div wire:loading.flex class="items-center justify-center py-12">
        <div class="w-8 h-8 border-4 border-teal-200 border-t-teal-600 rounded-full animate-spin"></div>
    </div>

    {{-- Resultados --}}
    <div wire:loading.remove>
        @if($products->isEmpty())
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 font-medium">No se encontraron productos</p>
                <p class="text-gray-400 text-sm mt-1">Intenta con otros filtros</p>
            </div>
        @else
            <p class="text-sm text-gray-500 mb-4">
                {{ $products->total() }} {{ $products->total() === 1 ? 'producto encontrado' : 'productos encontrados' }}
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
