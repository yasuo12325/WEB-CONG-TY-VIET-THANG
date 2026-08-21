<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('lr')) {
    /**
     * Locale-aware route(): resolves $name against the *current* locale's
     * route table (English routes are registered under an "en." name
     * prefix — see routes/web.php) so Blade views can link with a single
     * name regardless of which language is active, instead of branching
     * per-view on the locale.
     */
    function lr(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $target = app()->getLocale() === 'en' ? "en.{$name}" : $name;

        if (! Route::has($target)) {
            $target = $name;
        }

        return route($target, $parameters, $absolute);
    }
}

if (! function_exists('lr_is')) {
    /**
     * Locale-aware request()->routeIs() for nav active-states: checks both
     * the Vietnamese route name and its "en." counterpart, so a single
     * Blade condition works no matter which locale is currently active.
     */
    function lr_is(string $pattern): bool
    {
        return request()->routeIs($pattern) || request()->routeIs("en.{$pattern}");
    }
}

if (! function_exists('locale_switch_url')) {
    /**
     * The equivalent URL of the *current* page in $targetLocale — same
     * route, same bound models (re-keyed for the target locale, e.g. a
     * product's slug_en instead of slug), same query string. Falls back to
     * that locale's homepage only when the current route genuinely has no
     * equivalent (e.g. a 404), never a blind redirect to "/".
     */
    function locale_switch_url(string $targetLocale): string
    {
        $route = request()->route();
        $fallback = $targetLocale === 'en' ? url('/en') : url('/');

        if (! $route) {
            return $fallback;
        }

        $name = $route->getName();

        if (blank($name)) {
            return $fallback;
        }

        $baseName = str_starts_with($name, 'en.') ? substr($name, 3) : $name;
        $targetName = $targetLocale === 'en' ? "en.{$baseName}" : $baseName;

        if (! Route::has($targetName)) {
            return $fallback;
        }

        $originalLocale = app()->getLocale();
        app()->setLocale($targetLocale);

        try {
            // Route params can hold bound models (Product, News, Project)
            // whose URL key depends on the active locale (slug vs slug_en)
            // — regenerating while $targetLocale is active is what makes
            // the switcher land on the *translated* slug, not the VI one.
            $url = route($targetName, $route->parameters());
        } catch (\Throwable) {
            $url = $fallback;
        } finally {
            app()->setLocale($originalLocale);
        }

        $query = request()->getQueryString();

        return $query ? "{$url}?{$query}" : $url;
    }
}
