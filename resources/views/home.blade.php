@extends('layouts.app')

@section('title', __('home.meta_title'))
@section('meta_description', __('home.meta_description'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    @php
        $cities = [
            ['name' => 'Нячанг', 'text' => 'Главный морской курорт: пляжи, рынки, русскоязычный сервис, Винперл.', 'badges' => ['без английского', 'с детьми'], 'gradient' => 'linear-gradient(135deg, #0e7c7b, #35b0ae)', 'url' => route('preview.city'), 'soon' => false],
            ['name' => 'Фукуок', 'text' => 'Остров с белым песком и закатами. Спокойнее Нячанга, нужен базовый английский.', 'badges' => [], 'gradient' => 'linear-gradient(135deg, #e4572e, #f0966f)', 'url' => '#', 'soon' => true],
            ['name' => 'Дананг', 'text' => 'Город мостов и длинного пляжа Мике. Удобная база для Хойана и Ба На Хиллз.', 'badges' => [], 'gradient' => 'linear-gradient(135deg, #3a6ea5, #6fa3d8)', 'url' => '#', 'soon' => true],
            ['name' => 'Ханой', 'text' => 'Столица: старый квартал, уличная еда, озеро Хоанкием. Прохладнее зимой.', 'badges' => [], 'gradient' => 'linear-gradient(135deg, #5b5ea6, #8b8ec9)', 'url' => '#', 'soon' => true],
        ];

        $personas = [
            ['name' => 'Первый раз в Азии', 'text' => 'Что пугает и как всё устроено на самом деле'],
            ['name' => 'С детьми', 'text' => 'Пляжи без волн, медицина, еда для детей'],
            ['name' => 'Зимовка', 'text' => 'Жильё на месяц, визы, быт, цены'],
            ['name' => 'Бюджетно', 'text' => 'Минимальные цены и лайфхаки экономии'],
            ['name' => 'Без английского', 'text' => 'Где говорят по-русски, а где сложно'],
            ['name' => 'Цифровой кочевник', 'text' => 'Интернет, коворкинги, шум и розетки'],
        ];

        $articles = [
            ['id' => 'article:arrival', 'title' => 'Прилетели во Вьетнам: первый час без переплат', 'text' => 'Обмен в аэропорту, симка по паспорту, Grab вместо таксистов, чаевые.', 'url' => route('preview.arrival'), 'gradient' => 'linear-gradient(135deg, #3a6ea5, #6fa3d8)'],
            ['id' => 'article:markets', 'title' => 'Рынки Нячанга: цены, что покупать, как торговаться', 'text' => 'Дам, Чо Дем, Хон Чонг — часы работы, что брать и на что не вестись.', 'url' => route('preview.article'), 'gradient' => 'linear-gradient(135deg, #0e7c7b, #35b0ae)'],
            ['id' => 'article:visa', 'title' => 'Виза во Вьетнам для россиян в 2026', 'text' => 'Безвизовые 45 дней, e-visa, продление — только официальные источники.', 'url' => route('preview.article'), 'gradient' => 'linear-gradient(135deg, #2c7a4b, #52a875)'],
            ['id' => 'article:money', 'title' => 'Деньги во Вьетнаме: донг, обмен, карты', 'text' => 'Курс, где менять, работают ли российские карты, сколько наличных брать.', 'url' => route('preview.article'), 'gradient' => 'linear-gradient(135deg, #b8860b, #e0b04c)'],
        ];
    @endphp

    <section class="hero">
        <div class="container">
            <p class="hero-kicker">{{ __('home.hero_kicker') }}</p>
            <h1 class="hero-title">{{ __('home.hero_title') }}</h1>
            <p class="hero-text">{{ __('home.hero_text') }}</p>
            <div class="hero-links">
                <a href="{{ route('preview.article') }}" class="hero-link">Виза</a>
                <a href="{{ route('preview.arrival') }}" class="hero-link">Советы по прилёту</a>
                <a href="{{ route('preview.article') }}" class="hero-link">Деньги и симка</a>
                <a href="{{ route('preview.article') }}" class="hero-link">Когда ехать</a>
                <a href="{{ route('preview.article') }}" class="hero-link hero-link-honest">Честно: минусы и плюсы</a>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="home-layout">
            <div class="home-main">
        <section class="section">
            <div class="section-head">
                <h2 class="section-title">{{ __('home.cities_title') }}</h2>
            </div>
            <div class="card-grid">
                @foreach ($cities as $city)
                    <x-card
                        :url="$city['url']"
                        :title="$city['name']"
                        :text="$city['text']"
                        :badges="$city['badges']"
                        :gradient="$city['gradient']"
                        :soon="$city['soon']"
                    />
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">{{ __('home.personas_title') }}</h2>
            </div>
            <div class="persona-grid">
                @foreach ($personas as $persona)
                    <a href="#" class="persona-card">
                        <div class="persona-name">{{ $persona['name'] }}</div>
                        <p class="persona-text">{{ $persona['text'] }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">{{ __('home.articles_title') }}</h2>
            </div>
            <div class="card-grid">
                @foreach ($articles as $article)
                    <x-card
                        :url="$article['url']"
                        :title="$article['title']"
                        :text="$article['text']"
                        :gradient="$article['gradient']"
                        :wishlist="$article['id']"
                    />
                @endforeach
            </div>
        </section>

        <section class="section">
            <x-ad-slot />
        </section>
            </div>

            <aside class="home-aside">
                <div class="converter" id="converter" data-vnd-usd="26000" data-rub-usd="81">
                    <div class="converter-head">
                        <h2 class="converter-title">{{ __('home.converter_title') }}</h2>
                        <span class="converter-rate">{{ __('home.converter_rate') }}</span>
                    </div>
                    <div class="converter-fields">
                        <label class="converter-field converter-field--main">
                            <span class="converter-label">{{ __('home.converter_vnd') }}</span>
                            <input type="number" inputmode="numeric" min="0" step="10000" value="100000" data-cur="vnd">
                        </label>
                        <label class="converter-field">
                            <span class="converter-label">{{ __('home.converter_rub') }}</span>
                            <input type="number" inputmode="decimal" min="0" step="10" data-cur="rub">
                        </label>
                        <label class="converter-field">
                            <span class="converter-label">{{ __('home.converter_usd') }}</span>
                            <input type="number" inputmode="decimal" min="0" step="0.5" data-cur="usd">
                        </label>
                    </div>
                    <div class="converter-chips">
                        <button type="button" data-chip="50000">50k</button>
                        <button type="button" data-chip="100000">100k</button>
                        <button type="button" data-chip="200000">200k</button>
                        <button type="button" data-chip="500000">500k</button>
                        <button type="button" data-chip="1000000">1 {{ app()->getLocale() === 'ru' ? 'млн' : 'M' }}</button>
                    </div>
                    <p class="converter-hint">{!! __('home.converter_hint') !!}</p>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/currency.js') }}" defer></script>
@endpush
