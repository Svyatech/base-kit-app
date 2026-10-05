<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @if (request()->route()?->hasParameter('locale'))
        @php
            $routeName = request()->route()->getName();
            $routeParams = request()->route()->parameters();
        @endphp
        <link rel="alternate" hreflang="ru" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'ru'])) }}">
        <link rel="alternate" hreflang="en" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'en'])) }}">
        <link rel="alternate" hreflang="x-default" href="{{ route($routeName, array_merge($routeParams, ['locale' => 'ru'])) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <a class="logo" href="{{ route('home') }}">base<span>-kit</span></a>
            <x-lang-switcher />
        </div>
    </header>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        <div class="container">
            {{ config('app.name') }} &middot; {{ date('Y') }}
        </div>
    </footer>

    <x-cookie-banner />
</body>
</html>
