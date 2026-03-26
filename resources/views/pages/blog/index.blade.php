@extends('layouts.app')

@section('content')
<section class="page-hero py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Blog</h1>
        <p class="hero-subtitle text-lg max-w-2xl mx-auto">
            Consejos, noticias y novedades sobre salud visual.
        </p>
    </div>
</section>

<section class="py-16">
    <div class="container mx-auto px-4">
        @if($posts->isEmpty())
            <p class="text-center text-text-muted">No hay artículos publicados aún.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100">
                        @if($post->image)
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ \App\Support\MediaUrl::image($post->image) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-48 object-cover hover:opacity-90 transition">
                            </a>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-sm text-text-muted mb-3">
                                @if($post->published_at)
                                    <span>{{ $post->published_at->format('d M Y') }}</span>
                                @endif
                                @if($post->reading_time)
                                    <span>·</span>
                                    <span>{{ $post->reading_time }} min de lectura</span>
                                @endif
                            </div>

                            <h2 class="font-bold text-gray-900 text-xl mb-2 line-clamp-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-brand-600 transition">
                                    {{ $post->title }}
                                </a>
                            </h2>

                            @if($post->excerpt)
                                <p class="text-text-muted text-sm line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                            @endif

                            @if($post->tags && count($post->tags) > 0)
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach(array_slice($post->tags, 0, 3) as $tag)
                                        <span class="text-xs bg-brand-50 text-brand-700 px-2 py-0.5 rounded-full">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <a href="{{ route('blog.show', $post->slug) }}" class="text-brand-600 text-sm font-medium hover:underline">
                                Leer artículo →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
