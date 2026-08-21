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
        View::composer('layouts.app', function ($view) {
            $view->with('siteSettings', Setting::get('company_short_name') ? [
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
            ] : []);

            $view->with('navCategories', Category::query()
                ->active()
                ->topLevel()
                ->orderBy('sort_order')
                ->get());
        });
    }
}
