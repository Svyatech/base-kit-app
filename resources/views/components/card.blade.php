@props([
    'url' => '#',
    'title',
    'text' => null,
    'badges' => [],
    'gradient' => 'linear-gradient(135deg, #0e7c7b, #14908e)',
    'imgLabel' => null,
    'soon' => false,
    'wishlist' => null,
])

<a href="{{ $url }}" class="card {{ $soon ? 'card-soon' : '' }}">
    <div class="card-img" style="background: {{ $gradient }}">
        <span>{{ $imgLabel ?? __('ui.photo_placeholder') }}</span>
        @if ($wishlist)
            <button type="button" class="wishlist-btn wishlist-btn--sm card-wishlist" data-wishlist="{{ $wishlist }}" aria-label="{{ __('ui.wishlist_aria') }}">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </button>
        @endif
    </div>
    <div class="card-body">
        <div class="card-title">{{ $title }}</div>
        @if ($text)
            <p class="card-text">{{ $text }}</p>
        @endif
        @if ($soon)
            <span class="card-soon-tag">{{ __('ui.soon') }}</span>
        @elseif (count($badges))
            <div class="card-badges">
                @foreach ($badges as $badge)
                    <span class="badge">{{ $badge }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
