@props(['items' => []])
<nav aria-label="Breadcrumb" class="text-sm text-gray-500">
    <ol class="flex flex-wrap items-center gap-1">
        <li>
            <a href="{{ route('home') }}" class="hover:text-teal-600 transition-colors">Inicio</a>
        </li>
        @foreach($items as $item)
            <li class="flex items-center gap-1">
                <span>/</span>
                @if(isset($item['url']))
                    <a href="{{ $item['url'] }}" class="hover:text-teal-600 transition-colors">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-800 font-medium">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
