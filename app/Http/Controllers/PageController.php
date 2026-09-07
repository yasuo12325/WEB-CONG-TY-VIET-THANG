<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        $settings = $this->companySettings();

        return view('pages.about', [
            'settings' => $settings,
            'about' => $this->parseAboutContent($settings['about_content']),
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
        return view('pages.technology', [
            'content' => Setting::getTrans('technology_content'),
        ]);
    }

    public function partners()
    {
        return view('pages.partners', [
            'partners' => Partner::active()->get(),
        ]);
    }

    /**
     * about_content is a single free-form textarea (admin pastes one long
     * passage — see ManageSettings), not structured fields. This splits it
     * on blank lines into blocks, then treats a short one-line block with
     * no trailing sentence punctuation (or one that's fully upper-case) as
     * a section heading, so the "Giới thiệu công ty" page can render it as
     * a hero + alternating sections instead of one flat wall of text —
     * entirely from whatever the admin already typed, nothing invented.
     * Falls back gracefully (everything becomes "intro") for content that
     * doesn't follow this convention at all.
     */
    private function parseAboutContent(?string $content): array
    {
        $empty = ['title' => null, 'intro' => [], 'sections' => []];

        if (blank($content)) {
            return $empty;
        }

        $blocks = collect(preg_split('/\n{2,}/', trim($content)))
            ->map(fn ($block) => trim($block))
            ->filter()
            ->values();

        if ($blocks->isEmpty()) {
            return $empty;
        }

        $isAllCaps = fn (string $s): bool => mb_strtoupper($s, 'UTF-8') === $s && preg_match('/\p{L}/u', $s) === 1;

        $isHeading = function (string $block) use ($isAllCaps): bool {
            if (str_contains($block, "\n") || mb_strlen($block) > 100) {
                return false;
            }

            return $isAllCaps($block) || ! preg_match('/[.!?…]"?$/u', $block);
        };

        $title = null;
        $intro = [];
        $sections = [];
        $current = null;

        foreach ($blocks as $index => $block) {
            if ($index === 0 && $isAllCaps($block) && mb_strlen($block) > 10) {
                $title = $block;

                continue;
            }

            if ($isHeading($block)) {
                if ($current) {
                    $sections[] = $current;
                }
                $current = ['heading' => $block, 'paragraphs' => []];

                continue;
            }

            if ($current) {
                $current['paragraphs'][] = $block;
            } else {
                $intro[] = $block;
            }
        }

        if ($current) {
            $sections[] = $current;
        }

        return ['title' => $title, 'intro' => $intro, 'sections' => $sections];
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
            'about_summary' => Setting::get('about_summary'),
            'about_image_path' => Setting::get('about_image_path'),
            'about_content' => Setting::getTrans('about_content'),
        ];
    }
}
