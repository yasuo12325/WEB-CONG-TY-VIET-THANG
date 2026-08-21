<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registered globally (bootstrap/app.php) rather than only on the matched
 * route: a route-scoped middleware never runs for a URL that matches no
 * route at all (e.g. a typo under /en/...), so a 404 there would silently
 * render in the default locale instead of English. Detecting the locale
 * straight from the URL prefix here means every response — including error
 * pages — reflects the language the visitor was actually trying to reach.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->is('en') || $request->is('en/*') ? 'en' : 'vi';

        App::setLocale($locale);

        return $next($request);
    }
}
