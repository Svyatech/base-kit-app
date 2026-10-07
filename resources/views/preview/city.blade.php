@extends('layouts.app')

@section('title', 'Нячанг — путеводитель: пляжи, рынки, еда, цены')
@section('meta_description', 'Нячанг для туриста: когда ехать, где жить, пляжи, рынки, еда и транспорт. Проверено: октябрь 2026.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/city.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/city-map.js') }}" defer></script>
@endpush

@section('content')
    @php
        $facts = [
            ['label' => 'Сезон', 'value' => 'февраль — август'],
            ['label' => 'Язык', 'value' => 'можно без английского'],
            ['label' => 'Валюта', 'value' => 'донг (VND)'],
            ['label' => 'Аэропорт', 'value' => 'Камрань, 35 км'],
        ];

        $personas = [
            ['name' => 'С детьми', 'verdict' => 'Винперл, спокойные пляжи севернее канала'],
            ['name' => 'Без английского', 'verdict' => 'Русскоязычный сервис повсюду'],
            ['name' => 'Зимовка', 'verdict' => 'Жильё от $300/мес, вся инфраструктура'],
            ['name' => 'Бюджетно', 'verdict' => 'Еда от 30к донг, хостелы от $6'],
        ];

        $sections = [
            ['name' => 'Пляжи', 'text' => 'Городской, Доклет, Парагон — где волн нет', 'gradient' => 'linear-gradient(135deg, #0e7c7b, #35b0ae)'],
            ['name' => 'Рынки и шопинг', 'text' => 'Дам, Чо Дем, ночной рынок — цены и торг', 'gradient' => 'linear-gradient(135deg, #e4572e, #f0966f)'],
            ['name' => 'Еда', 'text' => 'Фо, бань ми, морепродукты — где и сколько', 'gradient' => 'linear-gradient(135deg, #2c7a4b, #52a875)'],
            ['name' => 'Достопримечательности', 'text' => 'Башни По Нагар, Лонг Шон, Винперл', 'gradient' => 'linear-gradient(135deg, #5b5ea6, #8b8ec9)'],
            ['name' => 'Жильё', 'text' => 'Районы, цены по месяцам, где селиться', 'gradient' => 'linear-gradient(135deg, #3a6ea5, #6fa3d8)'],
            ['name' => 'Транспорт', 'text' => 'Байк, такси, граб — сколько стоит', 'gradient' => 'linear-gradient(135deg, #b8860b, #e0b04c)'],
        ];

        $places = [
            ['id' => 'dam-market', 'name' => 'Рынок Дам (Cho Dam)', 'type' => 'Рынок', 'price' => 'бесплатно', 'hours' => '05:00–18:30', 'gradient' => 'linear-gradient(135deg, #e4572e, #f0966f)'],
            ['id' => 'po-nagar', 'name' => 'Башни По Нагар', 'type' => 'Достопримечательность', 'price' => '30k донг', 'hours' => '06:00–18:00', 'gradient' => 'linear-gradient(135deg, #5b5ea6, #8b8ec9)'],
            ['id' => 'beach', 'name' => 'Городской пляж', 'type' => 'Пляж', 'price' => 'лежак 50k', 'hours' => 'до 18:00 волны', 'gradient' => 'linear-gradient(135deg, #0e7c7b, #35b0ae)'],
        ];

        $mapZones = [
            ['name' => __('city.zone_north_name'), 'lat' => 12.295, 'lng' => 109.208, 'radius' => 2200, 'color' => '#2f6f68', 'desc' => __('city.zone_north_desc')],
            ['name' => __('city.zone_center_name'), 'lat' => 12.238, 'lng' => 109.188, 'radius' => 1900, 'color' => '#b9552f', 'desc' => __('city.zone_center_desc')],
            ['name' => __('city.zone_south_name'), 'lat' => 12.198, 'lng' => 109.218, 'radius' => 2100, 'color' => '#5b5ea6', 'desc' => __('city.zone_south_desc')],
        ];

        $mapTypes = [
            'all' => 'Все',
            'beach' => 'Пляжи',
            'market' => 'Рынки',
            'attraction' => 'Достопримечательности',
            'food' => 'Еда',
        ];

        $mapPlaces = [
            ['name' => 'Городской пляж (Tran Phu)', 'id' => 'beach', 'type' => 'beach', 'lat' => 12.2388, 'lng' => 109.1967, 'meta' => '6 км вдоль набережной', 'rating' => 4.5, 'reviews' => 31200, 'img' => asset('img/places/beach.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Nha+Trang+Beach+Tran+Phu'],
            ['name' => 'Рынок Дам (Cho Dam)', 'id' => 'dam-market', 'type' => 'market', 'lat' => 12.2439, 'lng' => 109.1909, 'meta' => '05:00–18:30 · продукты и сувениры', 'rating' => 4.3, 'reviews' => 8900, 'img' => asset('img/places/dam-market.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Cho+Dam+Market+Nha+Trang'],
            ['name' => 'Ночной рынок', 'id' => 'night-market', 'type' => 'market', 'lat' => 12.2385, 'lng' => 109.1947, 'meta' => '18:00–23:00 · сувениры, уличная еда', 'rating' => 4.2, 'reviews' => 5400, 'img' => asset('img/places/night-market.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Nha+Trang+Night+Market'],
            ['name' => 'Башни По Нагар', 'id' => 'po-nagar', 'type' => 'attraction', 'lat' => 12.2654, 'lng' => 109.1957, 'meta' => '06:00–18:00 · вход 30k донг', 'rating' => 4.6, 'reviews' => 25400, 'img' => asset('img/places/po-nagar.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Po+Nagar+Cham+Towers'],
            ['name' => 'Пагода Лонг Шон', 'id' => 'long-son', 'type' => 'attraction', 'lat' => 12.2537, 'lng' => 109.1811, 'meta' => 'белый Будда на холме', 'rating' => 4.5, 'reviews' => 12800, 'img' => asset('img/places/long-son.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Long+Son+Pagoda+Nha+Trang'],
            ['name' => 'Хон Чонг', 'id' => 'hon-chong', 'type' => 'attraction', 'lat' => 12.2716, 'lng' => 109.2057, 'meta' => 'скалы и вид на бухту', 'rating' => 4.4, 'reviews' => 9600, 'img' => asset('img/places/hon-chong.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Hon+Chong+Promontory+Nha+Trang'],
            ['name' => 'Канатная дорога Винперл', 'id' => 'vinpearl', 'type' => 'attraction', 'lat' => 12.2135, 'lng' => 109.2366, 'meta' => 'переправа на остров', 'rating' => 4.7, 'reviews' => 42100, 'img' => asset('img/places/vinpearl.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Vinpearl+Cable+Car+Nha+Trang'],
            ['name' => 'Квартал стрит-фуда (Biet Thu)', 'id' => 'biet-thu', 'type' => 'food', 'lat' => 12.2338, 'lng' => 109.1926, 'meta' => 'бары и уличная еда, вечером', 'rating' => 4.1, 'reviews' => 3700, 'img' => asset('img/places/biet-thu.jpg'), 'url' => 'https://www.google.com/maps/search/?api=1&query=Biet+Thu+Street+Nha+Trang'],
        ];

        $season = [
            ['month' => 'Янв', 'status' => 'mid', 'jelly' => true],
            ['month' => 'Фев', 'status' => 'good', 'jelly' => true],
            ['month' => 'Мар', 'status' => 'good', 'jelly' => false],
            ['month' => 'Апр', 'status' => 'good', 'jelly' => true],
            ['month' => 'Май', 'status' => 'good', 'jelly' => true],
            ['month' => 'Июн', 'status' => 'good', 'jelly' => true],
            ['month' => 'Июл', 'status' => 'good', 'jelly' => true],
            ['month' => 'Авг', 'status' => 'good', 'jelly' => true],
            ['month' => 'Сен', 'status' => 'mid', 'jelly' => false],
            ['month' => 'Окт', 'status' => 'bad', 'jelly' => false],
            ['month' => 'Ноя', 'status' => 'bad', 'jelly' => false],
            ['month' => 'Дек', 'status' => 'mid', 'jelly' => true],
        ];

        $budget = [
            ['item' => 'Жильё (7 ночей)', 'cheap' => '$70–120', 'comfort' => '$210–350', 'family' => '$280–490'],
            ['item' => 'Еда (на человека)', 'cheap' => '$50–70', 'comfort' => '$105–175', 'family' => '$280–420'],
            ['item' => 'Транспорт', 'cheap' => '$10–20', 'comfort' => '$35–60', 'family' => '$50–90'],
            ['item' => 'Развлечения', 'cheap' => '$20–40', 'comfort' => '$80–150', 'family' => '$150–250'],
        ];

        $budgetTotal = ['cheap' => '$150–250', 'comfort' => '$430–735', 'family' => '$760–1250'];
    @endphp

    <section class="city-hero" style="background: linear-gradient(135deg, rgba(14,124,123,0.92), rgba(20,144,142,0.75)), linear-gradient(135deg, #0e7c7b, #35b0ae)">
        <div class="container">
            <x-breadcrumbs :items="[
                ['label' => __('ui.bc_home'), 'url' => route('home')],
            ]" />
            <h1 class="city-title">Нячанг</h1>
            <p class="city-tagline">Главный курорт Южного Вьетнама: 6 км пляжа, рынки, остров Винперл</p>
            <div class="city-facts">
                @foreach ($facts as $fact)
                    <div class="city-fact">
                        <div class="city-fact-label">{{ $fact['label'] }}</div>
                        <div class="city-fact-value">{{ $fact['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="container">
        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Кому сюда</h2>
            </div>
            <div class="verdict-list">
                @foreach ($personas as $persona)
                    <div class="verdict">
                        <span class="badge">{{ $persona['name'] }}</span>
                        <p class="verdict-text">{{ $persona['verdict'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Карта города</h2>
            </div>
            <div class="map-chips">
                @foreach ($mapTypes as $type => $label)
                    <button type="button" class="map-chip{{ $loop->first ? ' is-active' : '' }}" data-type="{{ $type }}">{{ $label }}</button>
                @endforeach
                <button type="button" class="map-chip map-chip--zones" id="map-zones-toggle">{{ __('ui.map_zones') }}</button>
            </div>
            <div
                id="city-map"
                class="city-map"
                data-ykey="{{ config('services.yandex_maps.key') }}"
                data-center="{{ json_encode([12.2388, 109.1967]) }}"
                data-zoom="13"
                data-cta="{{ __('ui.map_cta') }}"
                data-wishlist-aria="{{ __('ui.wishlist_aria') }}"
                data-reviews="{{ __('ui.map_reviews') }}"
                data-markers='{!! json_encode($mapPlaces, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP) !!}'
                data-zones='{!! json_encode($mapZones, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP) !!}'
            ></div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Разделы города</h2>
            </div>
            <div class="card-grid">
                @foreach ($sections as $section)
                    <x-card
                        url="{{ route('preview.article') }}"
                        :title="$section['name']"
                        :text="$section['text']"
                        :gradient="$section['gradient']"
                    />
                @endforeach
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Когда ехать</h2>
                <a href="{{ route('preview.article') }}" class="section-link">Подробнее по месяцам →</a>
            </div>
            <div class="season">
                <div class="season-months">
                    @foreach ($season as $m)
                        <div class="season-month season-{{ $m['status'] }}">
                            <span class="season-name">{{ $m['month'] }}</span>
                            @if ($m['jelly'])
                                <span class="season-jelly" title="возможны медузы">~</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="season-legend">
                    <span><i class="season-good"></i> купательный сезон</span>
                    <span><i class="season-mid"></i> переходный</span>
                    <span><i class="season-bad"></i> дожди и шторм</span>
                    <span>~ возможны медузы</span>
                </div>
                <p class="season-note">Октябрь–ноябрь — пик дождей, купание на городском пляже запрещают. Лучшие месяцы — февраль–август.</p>
            </div>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Бюджет недели</h2>
                <a href="{{ route('preview.article') }}" class="section-link">Все цены города →</a>
            </div>
            <div class="table-wrap">
                <table class="budget-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Бюджет</th>
                            <th>Комфорт</th>
                            <th>Семья (2+2)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($budget as $row)
                            <tr>
                                <td>{{ $row['item'] }}</td>
                                <td>{{ $row['cheap'] }}</td>
                                <td>{{ $row['comfort'] }}</td>
                                <td>{{ $row['family'] }}</td>
                            </tr>
                        @endforeach
                        <tr class="budget-total">
                            <td>Итого за неделю</td>
                            <td>{{ $budgetTotal['cheap'] }}</td>
                            <td>{{ $budgetTotal['comfort'] }}</td>
                            <td>{{ $budgetTotal['family'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="budget-note">Без перелёта. Цены примерные, ориентир — октябрь 2026; подробности в статьях про жильё и еду.</p>
        </section>

        <section class="section">
            <div class="section-head">
                <h2 class="section-title">Места</h2>
            </div>
            <div class="place-list">
                @foreach ($places as $place)
                    <a href="{{ route('preview.article') }}" class="place-row">
                        <div class="place-thumb" style="background: {{ $place['gradient'] }}"></div>
                        <div class="place-info">
                            <div class="place-name">{{ $place['name'] }}</div>
                            <div class="place-meta">{{ $place['type'] }} · {{ $place['price'] }} · {{ $place['hours'] }}</div>
                        </div>
                        <button type="button" class="wishlist-btn" data-wishlist="{{ $place['id'] }}" aria-label="{{ __('ui.wishlist_aria') }}">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                        </button>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section">
            <x-ad-slot />
        </section>
    </div>
@endsection
