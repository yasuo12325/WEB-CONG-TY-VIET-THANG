<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Composed for every view (not just layouts.app): a child view's
        // @section('content') runs and captures its output *before* Blade
        // renders the parent layout, in its own data scope, so data added
        // only to 'layouts.app' never reaches content written in e.g.
        // home.blade.php. Registering on '*' — with the lookups memoized so
        // multiple views in one request only hit the DB once — makes
        // $siteSettings/$navCategories reliably available everywhere.
        View::composer('*', function ($view) {
            static $siteSettings;
            static $navCategories;

            $siteSettings ??= Setting::get('company_short_name') ? [
                'company_name' => Setting::get('company_name'),
                'company_short_name' => Setting::get('company_short_name'),
                'logo_path' => Setting::get('logo_path'),
                'phone' => Setting::get('phone'),
                'email' => Setting::get('email'),
                'website' => Setting::get('website'),
                'fax' => Setting::get('fax'),
                'headquarters_address' => Setting::get('headquarters_address'),
                'office_address' => Setting::get('office_address'),
                'founded_year' => Setting::get('founded_year'),
                'employee_count' => Setting::get('employee_count'),
                'partner_count' => Setting::get('partner_count'),
                'about_summary' => Setting::get('about_summary'),
            ] : [];

            $navCategories ??= Category::query()
                ->active()
                ->topLevel()
                ->orderBy('sort_order')
                ->get();

            $view->with('siteSettings', $siteSettings);
            $view->with('navCategories', $navCategories);
        });
    }
}
