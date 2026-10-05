@php
    $other = app()->getLocale() === 'ru' ? 'en' : 'ru';
    $currentRoute = request()->route();
    $params = $currentRoute ? $currentRoute->parameters() : [];
    $params['locale'] = $other;
    $url = $currentRoute ? route($currentRoute->getName(), $params) : '/'.$other;
@endphp

<a href="{{ $url }}" class="lang-switch" data-locale="{{ $other }}" aria-label="{{ __('ui.lang_switch_aria') }}">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <circle cx="12" cy="12" r="10"/>
        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20 15.3 15.3 0 0 1 0-20"/>
    </svg>
    {{ strtoupper($other) }}
</a>

<script>
    document.querySelector('.lang-switch').addEventListener('click', function () {
        document.cookie = 'locale=' + this.dataset.locale + ';path=/;max-age=31536000;SameSite=Lax';
    });
</script>
