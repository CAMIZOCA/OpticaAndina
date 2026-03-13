@props(['title' => 'Conoce nuestras instalaciones', 'video', 'description' => null])

<section class="py-16 bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="section-title text-white mb-4">{{ $title }}</h2>
            @if($description)
            <p class="text-gray-300 max-w-2xl mx-auto">{{ $description }}</p>
            @endif
        </div>

        @if($video && $video->url)
        <div class="max-w-4xl mx-auto">
            <div class="relative w-full bg-black rounded-lg overflow-hidden" style="padding-bottom: 56.25%;">
                @if(str_contains($video->url, 'youtube'))
                    <iframe 
                        class="absolute inset-0 w-full h-full"
                        src="{{ str_replace('watch?v=', 'embed/', str_replace('youtube.com/', 'youtube.com/embed/', $video->url)) }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                @elseif(str_contains($video->url, 'vimeo'))
                    <iframe 
                        class="absolute inset-0 w-full h-full"
                        src="{{ str_replace('vimeo.com/', 'player.vimeo.com/video/', $video->url) }}" 
                        frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                @else
                    <iframe 
                        class="absolute inset-0 w-full h-full"
                        src="{{ $video->url }}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                @endif
            </div>
        </div>
        @else
        <div class="max-w-4xl mx-auto bg-gray-800 rounded-lg p-12 text-center">
            <p class="text-text-muted">No hay video disponible en este momento</p>
        </div>
        @endif
    </div>
</section>

