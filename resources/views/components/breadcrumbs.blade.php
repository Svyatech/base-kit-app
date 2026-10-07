@props(['items' => []])

<nav aria-label="{{ __('ui.breadcrumbs_aria') }}">
    <ol class="breadcrumbs">
        @foreach ($items as $item)
            <li>
                @if (! $loop->last && isset($item['url']))
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @else
                    <span>{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
