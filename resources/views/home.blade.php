@extends('layouts.app')

@section('title', config('app.name') . ' — движок контентных сайтов')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <div class="hero">
        <h1>Движок запущен.<br>Осталось наполнить его <span>смыслом</span>.</h1>
        <p>Базовый каркас контентного сайта: серверный рендеринг на Blade, без лишних слоёв. Клонируй, наполняй, публикуй.</p>
    </div>

    <div class="stack">
        <div class="stack-card">
            <div class="name">Laravel 13</div>
            <div class="role">фреймворк</div>
        </div>
        <div class="stack-card">
            <div class="name">PHP 8.5</div>
            <div class="role">FrankenPHP, один контейнер</div>
        </div>
        <div class="stack-card">
            <div class="name">PostgreSQL 17</div>
            <div class="role">данные, jsonb</div>
        </div>
        <div class="stack-card">
            <div class="name">Redis 7</div>
            <div class="role">кэш, сессии, очереди</div>
        </div>
    </div>

    <div class="commands">
        <div><span class="cmd">make dev</span> <span class="hint"># разработка, правки видны по F5</span></div>
        <div><span class="cmd">make migrate</span> <span class="hint"># ядро + тематика</span></div>
        <div><span class="cmd">make test</span> <span class="hint"># тесты</span></div>
    </div>
@endsection
