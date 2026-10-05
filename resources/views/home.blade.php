@extends('layouts.app')

@section('title', config('app.name') . ' — ' . __('home.meta_title'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    <div class="hero">
        <h1>{{ __('home.hero_line1') }}<br>{{ __('home.hero_line2') }} <span>{{ __('home.hero_accent') }}</span>.</h1>
        <p>{{ __('home.hero_text') }}</p>
    </div>

    <div class="stack">
        <div class="stack-card">
            <div class="name">Laravel 13</div>
            <div class="role">{{ __('home.stack_framework') }}</div>
        </div>
        <div class="stack-card">
            <div class="name">PHP 8.5</div>
            <div class="role">{{ __('home.stack_php') }}</div>
        </div>
        <div class="stack-card">
            <div class="name">PostgreSQL 17</div>
            <div class="role">{{ __('home.stack_db') }}</div>
        </div>
        <div class="stack-card">
            <div class="name">Redis 7</div>
            <div class="role">{{ __('home.stack_redis') }}</div>
        </div>
    </div>

    <div class="commands">
        <div><span class="cmd">make dev</span> <span class="hint"># {{ __('home.cmd_dev') }}</span></div>
        <div><span class="cmd">make migrate</span> <span class="hint"># {{ __('home.cmd_migrate') }}</span></div>
        <div><span class="cmd">make test</span> <span class="hint"># {{ __('home.cmd_test') }}</span></div>
    </div>
@endsection
