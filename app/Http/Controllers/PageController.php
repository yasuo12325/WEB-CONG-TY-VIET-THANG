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
            'tech' => $this->parseTechnologyContent(Setting::getTrans('technology_content')),
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

    /**
     * technology_content is a Filament RichEditor field (real HTML with
     * <h2>/<h3> headings, <ul> lists, an embedded <img>, and — if the admin
     * used the quote tool — a closing <blockquote>), unlike about_content's
     * plain textarea. So this walks the actual DOM instead of guessing at
     * plain-text heading shapes: the first <img> found becomes the hero
     * image, content before the first heading is the intro, each heading
     * starts a new section carrying the HTML that follows it, and a
     * <blockquote> (wherever it appears) becomes the highlighted closing
     * statement. Empty spacer <p></p> nodes (which the editor leaves
     * behind around an inserted image) are skipped. Falls back to
     * rendering everything as intro if there are no headings at all.
     */
    private function parseTechnologyContent(?string $html): array
    {
        $empty = ['image' => null, 'intro' => '', 'sections' => [], 'closing' => null];

        if (blank($html)) {
            return $empty;
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?><div>'.$html.'</div>', LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $root = $dom->getElementsByTagName('div')->item(0);

        if (! $root) {
            return $empty;
        }

        $image = null;
        $introHtml = '';
        $sections = [];
        $current = null;
        $closingHtml = null;

        foreach ($root->childNodes as $node) {
            if ($node->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if ($image === null) {
                $imgNodes = $node->getElementsByTagName('img');

                if ($imgNodes->length > 0) {
                    $image = $imgNodes->item(0)->getAttribute('src');

                    if (trim($node->textContent) === '') {
                        continue; // node exists only to hold the image
                    }
                }
            }

            if (trim($node->textContent) === '') {
                continue; // empty <p></p> spacer left by the editor
            }

            $tag = strtolower($node->nodeName);

            if (in_array($tag, ['h1', 'h2', 'h3', 'h4'], true)) {
                if ($current) {
                    $sections[] = $current;
                }
                $current = ['heading' => trim($node->textContent), 'body' => ''];

                continue;
            }

            if ($tag === 'blockquote') {
                $closingHtml = $this->innerHtml($node);

                continue;
            }

            $nodeHtml = $dom->saveHTML($node);

            if ($current) {
                $current['body'] .= $nodeHtml;
            } else {
                $introHtml .= $nodeHtml;
            }
        }

        if ($current) {
            $sections[] = $current;
        }

        return ['image' => $image, 'intro' => $introHtml, 'sections' => $sections, 'closing' => $closingHtml];
    }

    private function innerHtml(\DOMNode $node): string
    {
        $html = '';

        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument->saveHTML($child);
        }

        return $html;
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
