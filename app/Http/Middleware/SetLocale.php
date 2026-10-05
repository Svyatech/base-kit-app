<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SetLocale
 */
class SetLocale
{
    /**
     * @param Request                    $request
     * @param Closure(Request): Response $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (!in_array($locale, config('app.locales'), true)) {
            abort(404);
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
