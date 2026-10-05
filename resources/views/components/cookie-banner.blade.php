@if (! request()->cookie('cookie_consent'))
    <div class="cookie-banner" id="cookie-banner" role="dialog" aria-label="Cookies">
        <p class="cookie-text">
            {{ __('ui.cookie_text') }}
            <a href="{{ route('privacy') }}">{{ __('ui.cookie_more') }}</a>
        </p>
        <button type="button" class="cookie-accept" id="cookie-accept">{{ __('ui.cookie_accept') }}</button>
    </div>

    <script>
        document.getElementById('cookie-accept').addEventListener('click', function () {
            document.cookie = 'cookie_consent=1;path=/;max-age=31536000;SameSite=Lax';
            document.getElementById('cookie-banner').remove();
        });
    </script>
@endif
