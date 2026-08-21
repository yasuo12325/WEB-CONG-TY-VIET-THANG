<?php

namespace App\Models\Concerns;

/**
 * Simple sibling-column localization: each translatable field "foo" has an
 * optional "foo_en" column. The base column always holds the Vietnamese
 * content (the site's source of truth, never overwritten by a translation).
 * ->trans('foo') returns the field for the current app locale, falling back
 * to Vietnamese when no English value has been entered yet — the UI must
 * never show null/blank just because a translation is missing.
 *
 * Models using this trait declare which fields are translatable via a
 * $translatable array, e.g. protected array $translatable = ['name', 'description'];
 */
trait HasTranslatedFields
{
    public function trans(string $field): ?string
    {
        if (app()->getLocale() !== 'en') {
            return $this->{$field};
        }

        $enField = "{$field}_en";

        return filled($this->{$enField} ?? null) ? $this->{$enField} : $this->{$field};
    }

    /**
     * Whether the English edition of $field has actually been filled in —
     * used by the admin to flag missing translations rather than silently
     * falling back, and by anything that needs to know it's seeing a
     * fallback rather than a real translation.
     */
    public function hasTranslation(string $field): bool
    {
        $enField = "{$field}_en";

        return filled($this->{$enField} ?? null);
    }

    /**
     * True only if every field this model declares as translatable has an
     * English value. Used by Filament list tables to flag incomplete rows.
     */
    public function isFullyTranslated(): bool
    {
        foreach ($this->translatable ?? [] as $field) {
            if (! $this->hasTranslation($field)) {
                return false;
            }
        }

        return true;
    }
}
