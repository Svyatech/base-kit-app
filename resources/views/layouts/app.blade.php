<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description')">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            if (!t) t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.dataset.theme = t;
        })();
    </script>
    @if (request()->route()?->hasParameter('locale'))
        @php
            $routeName = request()->route()->getName();
            $routeParams = request()->route()->parameters();
        @endphp
        <link rel="alternate" hreflang="ru" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'ru'])) }}">
        <link rel="alternate" hreflang="en" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'en'])) }}">
        <link rel="alternate" hreflang="x-default" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'ru'])) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@600;700;800&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a class="logo" href="{{ route('home') }}">{!! str_replace('-', '<span>.</span>', e(config('app.name'))) !!}</a>
            <div class="header-actions">
                <a href="{{ route('preview.my') }}" class="wishlist-link" aria-label="{{ __('ui.wishlist_link_aria') }}">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    <span class="wishlist-count" hidden>0</span>
                </a>
                <x-theme-toggle />
                <x-lang-switcher />
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <nav class="footer-nav" aria-label="{{ __('ui.footer_nav_aria') }}">
                <a href="{{ route('home') }}">{{ __('ui.footer_home') }}</a>
                <a href="{{ route('privacy') }}">{{ __('ui.footer_privacy') }}</a>
            </nav>
            <p class="footer-note">{!! str_replace('-', '<span>.</span>', e(config('app.name'))) !!} &middot; {{ date('Y') }} &middot; {{ __('ui.footer_note') }}</p>
        </div>
    </footer>

    <x-cookie-banner />

    <script src="{{ asset('js/wishlist.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
