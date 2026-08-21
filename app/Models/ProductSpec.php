<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpec extends Model
{
    use HasTranslatedFields;

    // spec_value is deliberately NOT translatable by default: numbers,
    // units, model codes and standards must stay identical between VI/EN.
    protected array $translatable = ['spec_group', 'spec_key'];

    protected $fillable = [
        'product_id',
        'spec_group',
        'spec_group_en',
        'spec_key',
        'spec_key_en',
        'spec_value',
        'spec_value_en',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * spec_value has its own accessor (rather than being in $translatable)
     * so a translator can still override it for the rare spec whose value
     * is descriptive text, while every numeric/unit value is left alone by
     * default (falls back to the original because spec_value_en is empty).
     */
    public function transValue(): ?string
    {
        return $this->trans('spec_value');
    }
}
