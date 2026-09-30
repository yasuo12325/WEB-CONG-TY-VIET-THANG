<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasTranslatedFields;

    protected array $translatable = ['country', 'specialty'];

    protected $fillable = [
        'name',
        'logo_path',
        'website_url',
        'country',
        'country_en',
        'specialty',
        'specialty_en',
        'sort_order',
        'is_active',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('sort_order');
    }
}
