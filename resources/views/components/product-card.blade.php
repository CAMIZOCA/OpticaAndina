@props(['product'])
<article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 group">
    <a href="{{ route('catalogo.producto', [$product->category->slug, $product->slug]) }}" class="block">
        @if($product->coverImage)
            <div class="aspect-square overflow-hidden bg-gray-50">
                <img src="{{ asset('storage/' . $product->coverImage->path) }}"
                     alt="{{ $product->coverImage->alt ?? $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy">
            </div>
        @else
            <div class="aspect-square bg-gray-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        @endif
        <div class="p-4">
            @if($product->brand)
                <p class="text-xs text-teal-600 font-medium uppercase tracking-wide mb-1">{{ $product->brand->name }}</p>
            @endif
            <h3 class="font-semibold text-gray-800 group-hover:text-teal-600 transition-colors line-clamp-2">
                {{ $product->name }}
            </h3>
            @if($product->short_description)
                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $product->short_description }}</p>
            @endif
            <div class="mt-3 flex items-center justify-between">
                <span class="text-xs px-2 py-1 rounded-full {{ $product->is_available ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $product->is_available ? 'Disponible' : 'Sin stock' }}
                </span>
                <span class="text-teal-600 text-sm font-medium">Ver detalles →</span>
            </div>
        </div>
    </a>
</article>
