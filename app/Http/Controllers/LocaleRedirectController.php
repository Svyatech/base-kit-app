<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class LocaleRedirectController
 */
class LocaleRedirectController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $locales = config('app.locales');
        $locale = $request->cookie('locale');

        if (!in_array($locale, $locales, true)) {
            $locale = $request->header('Accept-Language')
                ? $request->getPreferredLanguage($locales)
                : null;

            $locale = $locale ?? $locales[0];
        }

        return redirect('/' . $locale, 302);
    }
}
