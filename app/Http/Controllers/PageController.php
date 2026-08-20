<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'settings' => $this->companySettings(),
        ]);
    }

    public function fields()
    {
        return view('pages.fields', [
            'categories' => Category::active()->topLevel()->orderBy('sort_order')->get(),
        ]);
    }

    public function technology()
    {
        return view('pages.technology');
    }

    public function partners()
    {
        return view('pages.partners', [
            'partners' => Partner::active()->get(),
        ]);
    }

    private function companySettings(): array
    {
        return [
            'company_name' => Setting::get('company_name'),
            'company_name_intl' => Setting::get('company_name_intl'),
            'company_short_name' => Setting::get('company_short_name'),
            'founded_year' => Setting::get('founded_year'),
            'charter_capital' => Setting::get('charter_capital'),
            'employee_count' => Setting::get('employee_count'),
            'ceo_name' => Setting::get('ceo_name'),
            'headquarters_address' => Setting::get('headquarters_address'),
            'office_address' => Setting::get('office_address'),
            'about_summary' => Setting::get('about_summary'),
        ];
    }
}
