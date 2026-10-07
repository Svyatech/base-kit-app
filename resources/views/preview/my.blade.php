@extends('layouts.app')

@section('title', __('ui.my_title'))
@section('meta_description', 'Ваш список мест и статей во Вьетнаме. Хранится в этом браузере, без регистрации.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/city.css') }}">
@endpush

@section('content')
    @php
        $mapPlaces = [
            ['id' => 'beach', 'name' => 'Городской пляж (Tran Phu)', 'type' => 'beach', 'lat' => 12.2388, 'lng' => 109.1967, 'meta' => '6 км вдоль набережной', 'rating' => 4.5, 'reviews' => 31200, 'img' => asset('img/places/beach.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Nha+Trang+Beach+Tran+Phu'],
            ['id' => 'dam-market', 'name' => 'Рынок Дам (Cho Dam)', 'type' => 'market', 'lat' => 12.2439, 'lng' => 109.1909, 'meta' => '05:00–18:30 · продукты и сувениры', 'rating' => 4.3, 'reviews' => 8900, 'img' => asset('img/places/dam-market.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Cho+Dam+Market+Nha+Trang'],
            ['id' => 'night-market', 'name' => 'Ночной рынок', 'type' => 'market', 'lat' => 12.2385, 'lng' => 109.1947, 'meta' => '18:00–23:00 · сувениры, уличная еда', 'rating' => 4.2, 'reviews' => 5400, 'img' => asset('img/places/night-market.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Nha+Trang+Night+Market'],
            ['id' => 'po-nagar', 'name' => 'Башни По Нагар', 'type' => 'attraction', 'lat' => 12.2654, 'lng' => 109.1957, 'meta' => '06:00–18:00 · вход 30k донг', 'rating' => 4.6, 'reviews' => 25400, 'img' => asset('img/places/po-nagar.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Po+Nagar+Cham+Towers'],
            ['id' => 'long-son', 'name' => 'Пагода Лонг Шон', 'type' => 'attraction', 'lat' => 12.2537, 'lng' => 109.1811, 'meta' => 'белый Будда на холме', 'rating' => 4.5, 'reviews' => 12800, 'img' => asset('img/places/long-son.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Long+Son+Pagoda+Nha+Trang'],
            ['id' => 'hon-chong', 'name' => 'Хон Чонг', 'type' => 'attraction', 'lat' => 12.2716, 'lng' => 109.2057, 'meta' => 'скалы и вид на бухту', 'rating' => 4.4, 'reviews' => 9600, 'img' => asset('img/places/hon-chong.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Hon+Chong+Promontory+Nha+Trang'],
            ['id' => 'vinpearl', 'name' => 'Канатная дорога Винперл', 'type' => 'attraction', 'lat' => 12.2135, 'lng' => 109.2366, 'meta' => 'переправа на остров', 'rating' => 4.7, 'reviews' => 42100, 'img' => asset('img/places/vinpearl.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Vinpearl+Cable+Car+Nha+Trang'],
            ['id' => 'biet-thu', 'name' => 'Квартал стрит-фуда (Biet Thu)', 'type' => 'food', 'lat' => 12.2338, 'lng' => 109.1926, 'meta' => 'бары и уличная еда, вечером', 'rating' => 4.1, 'reviews' => 3700, 'img' => asset('img/places/biet-thu.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Biet+Thu+Street+Nha+Trang'],
        ];
        $articles = [
            ['id' => 'article:arrival', 'title' => 'Прилетели во Вьетнам: первый час без переплат', 'text' => 'Обмен в аэропорту, симка по паспорту, Grab вместо таксистов, чаевые.', 'url' => route('preview.arrival')],
            ['id' => 'article:markets', 'title' => 'Рынки Нячанга: цены, что покупать, как торговаться', 'text' => 'Дам, Чо Дем, Хон Чонг — часы работы, что брать и на что не вестись.', 'url' => route('preview.article')],
            ['id' => 'article:visa', 'title' => 'Виза во Вьетнам для россиян в 2026', 'text' => 'Безвизовые 45 дней, e-visa, продление — только официальные источники.', 'url' => route('preview.article')],
            ['id' => 'article:money', 'title' => 'Деньги во Вьетнаме: донг, обмен, карты', 'text' => 'Курс, где менять, работают ли российские карты, сколько наличных брать.', 'url' => route('preview.article')],
        ];
    @endphp

    <div class="container">
        <x-breadcrumbs :items="[
            ['label' => __('ui.bc_home'), 'url' => route('home')],
            ['label' => __('ui.my_title')],
        ]" />

        <section class="section">
            <div class="section-head">
                <h1 class="section-title">{{ __('ui.my_title') }}</h1>
                <button type="button" id="my-share" class="share-btn" data-label="{{ __('ui.my_share') }}" data-copied="{{ __('ui.my_copied') }}">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.6 10.5 6.8-4M8.6 13.5l6.8 4"/></svg>
                    <span>{{ __('ui.my_share') }}</span>
                </button>
            </div>
            <p class="my-note">{{ __('ui.my_note') }}</p>

            <div id="my-list" class="my-list" data-google="{{ __('ui.map_google') }}" data-wishlist-aria="{{ __('ui.wishlist_remove_aria') }}" data-reviews="{{ __('ui.map_reviews') }}" data-places='{!! json_encode($mapPlaces, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP) !!}'></div>

            <div id="my-articles-wrap" hidden>
                <h2 class="section-title my-subtitle">{{ __('ui.my_articles') }}</h2>
                <div id="my-articles" class="my-list" data-articles='{!! json_encode($articles, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP) !!}'></div>
            </div>

            <p id="my-empty" class="my-empty" hidden>{{ __('ui.my_empty') }}</p>
        </section>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/my.js') }}" defer></script>
@endpush
