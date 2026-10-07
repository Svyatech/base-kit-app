@extends('layouts.app')

@section('title', 'Рынки Нячанга: цены, что покупать, как торговаться')
@section('meta_description', 'Рынки Нячанга: Дам, Чо Дем, ночной рынок. Цены на фрукты и сувениры, часы работы, как торговаться и на что не вестись. Проверено: октябрь 2026.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/article.css') }}">
@endpush

@section('content')
    @php
        $toc = [
            ['id' => 'markets', 'label' => 'Главные рынки'],
            ['id' => 'prices', 'label' => 'Цены на октябрь 2026'],
            ['id' => 'bargain', 'label' => 'Как торговаться'],
            ['id' => 'pitfalls', 'label' => 'Подводные камни'],
            ['id' => 'faq', 'label' => 'Частые вопросы'],
        ];

        $related = [
            ['title' => 'Еда в Нячанге: где и что есть', 'text' => 'Фо, бань ми, морепродукты — адреса и цены', 'gradient' => 'linear-gradient(135deg, #2c7a4b, #52a875)'],
            ['title' => 'Транспорт в Нячанге', 'text' => 'Байк, такси, Grab — тарифы и нюансы', 'gradient' => 'linear-gradient(135deg, #b8860b, #e0b04c)'],
            ['title' => 'Жильё в Нячанге: районы и цены', 'text' => 'Где селиться на неделю и на зимовку', 'gradient' => 'linear-gradient(135deg, #3a6ea5, #6fa3d8)'],
        ];

        $faq = [
            ['q' => 'Нужно ли торговаться на рынках Нячанга?', 'a' => 'Да, на туристических рынках (Дам, ночной) начальная цена завышена в 1,5–2 раза. На продуктовых рядах торг уместен слабо.'],
            ['q' => 'Принимают ли карты на рынках?', 'a' => 'Почти нигде. Наличные донги — обязательно, мелкими купюрами.'],
            ['q' => 'Когда лучше приходить на рынок Дам?', 'a' => 'Утром до 10:00 — свежие продукты и меньше туристов. Вечером часть рядов закрыта.'],
            ['q' => 'Где менять деньги рядом с рынками?', 'a' => 'В ювелирных лавках вокруг рынка Дам курс обычно лучше банковского. Сверяйте с курсом дня.'],
        ];
    @endphp

    <div class="container">
        <x-breadcrumbs :items="[
            ['label' => __('ui.bc_home'), 'url' => route('home')],
            ['label' => 'Нячанг', 'url' => route('preview.city')],
            ['label' => 'Рынки Нячанга'],
        ]" />

        <div class="article-layout">
            <aside class="toc">
                <div class="toc-title">{{ __('ui.toc_title') }}</div>
                <ol class="toc-list">
                    @foreach ($toc as $item)
                        <li><a href="#{{ $item['id'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ol>
            </aside>

            <article class="article">
                <div class="article-head">
                    <h1 class="article-title">Рынки Нячанга: цены, что покупать, как торговаться</h1>
                    <button type="button" class="wishlist-btn" data-wishlist="article:markets" aria-label="{{ __('ui.wishlist_aria') }}">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </button>
                </div>
                <div class="article-meta">
                    <span>{{ __('ui.checked_at') }}: 4 октября 2026</span>
                    <span>·</span>
                    <span>6 мин чтения</span>
                </div>

                <p class="article-lead">
                    Главные рынки Нячанга — Дам (продукты и сувениры днём), ночной рынок
                    (сувениры и уличная еда) и Чо Дем. Цены туристические: торгуйтесь до 50–70%
                    от первой названной. Картами почти нигде не расплатиться — нужны наличные донги.
                </p>

                <section id="markets">
                    <h2>Главные рынки</h2>
                    <p>
                        Рынок Дам (Cho Dam) — центральный и самый большой: круглое здание улицы
                        Phan Boi Chau. Нижний ярус — продукты и морепродукты, верхний — одежда
                        и сувениры. Работает 05:00–18:30.
                    </p>
                    <div class="place-cards">
                        <div class="place-card">
                            <div class="place-card-name">Рынок Дам (Cho Dam)</div>
                            <div class="place-card-meta">05:00–18:30 · вход бесплатный</div>
                            <a class="place-card-map" href="https://maps.google.com/?q=Cho+Dam+Nha+Trang" target="_blank" rel="noopener">Google Maps →</a>
                        </div>
                        <div class="place-card">
                            <div class="place-card-name">Ночной рынок</div>
                            <div class="place-card-meta">18:00–23:00 · сувениры, уличная еда</div>
                            <a class="place-card-map" href="https://maps.google.com/?q=Nha+Trang+Night+Market" target="_blank" rel="noopener">Google Maps →</a>
                        </div>
                    </div>
                </section>

                <section id="prices">
                    <h2>Цены на октябрь 2026</h2>
                    <p>Ориентиры после торга. Курс: 25 000 донг ≈ 1 $.</p>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr><th>Товар</th><th>Называют</th><th>Реальная цена</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Манго (1 кг)</td><td>80–100k</td><td>40–60k</td></tr>
                                <tr><td>Драконий фрукт (1 кг)</td><td>50–70k</td><td>25–40k</td></tr>
                                <tr><td>Футболка</td><td>200–300k</td><td>100–150k</td></tr>
                                <tr><td>Кофе робуста (500 г)</td><td>250–350k</td><td>150–220k</td></tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <x-ad-slot :label="__('ui.ad_article')" />

                <section id="bargain">
                    <h2>Как торговаться</h2>
                    <ul>
                        <li>Называйте цену вдвое ниже первой — и поднимайтесь медленно.</li>
                        <li>Уходите, если не соглашаются: чаще всего окликнут с нужной ценой.</li>
                        <li>Расплачивайтесь мелкими купюрами — «нет сдачи» это приём.</li>
                    </ul>
                </section>

                <section id="pitfalls" class="pitfalls">
                    <h2>Подводные камни</h2>
                    <ul>
                        <li>«Жемчуг» и «брендовые» сумки на ночном рынке — подделки без исключений.</li>
                        <li>Весы на фруктовых рядах бывают «настроены» — просите взвесить при вас.</li>
                        <li>Карманники в толпе у входа на Дам: рюкзак вперёд.</li>
                    </ul>
                </section>

                <section id="faq">
                    <h2>Частые вопросы</h2>
                    <div class="faq-list">
                        @foreach ($faq as $item)
                            <details class="faq-item">
                                <summary>{{ $item['q'] }}</summary>
                                <p>{{ $item['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </section>

                <div class="partner-block">
                    <div class="partner-title">{{ __('ui.partner_title') }}</div>
                    <p class="partner-text">Трансфер из аэропорта Камрань и экскурсии по Нячангу — партнёрский блок (Travelpayouts / Klook).</p>
                    <x-ad-slot :label="__('ui.ad_partner')" />
                </div>

                <section class="section">
                    <div class="section-head">
                        <h2 class="section-title">{{ __('ui.related_title') }}</h2>
                    </div>
                    <div class="card-grid">
                        @foreach ($related as $article)
                            <x-card
                                url="{{ route('preview.article') }}"
                                :title="$article['title']"
                                :text="$article['text']"
                                :gradient="$article['gradient']"
                            />
                        @endforeach
                    </div>
                </section>
            </article>
        </div>
    </div>
@endsection
