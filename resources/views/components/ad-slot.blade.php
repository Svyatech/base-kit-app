@props(['label' => null])

<div class="ad-slot" role="complementary" aria-label="{{ __('ui.ad_aria') }}">
    {{ $label ?? __('ui.ad_placeholder') }}
</div>
