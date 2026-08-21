<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasTranslatedFields, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected array $translatable = ['name', 'short_description', 'description'];

    protected $fillable = [
        'category_id',
        'name',
        'name_en',
        'slug',
        'slug_en',
        'model_number',
        'short_description',
        'short_description_en',
        'description',
        'description_en',
        'status',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (blank($product->slug)) {
                $product->slug = Str::slug($product->name);
            }

            if (filled($product->name_en) && blank($product->slug_en)) {
                $product->slug_en = Str::slug($product->name_en);
            }

            if ($product->status === self::STATUS_PUBLISHED && blank($product->published_at)) {
                $product->published_at = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProductDocument::class)->orderBy('sort_order');
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class)->orderBy('sort_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * English URLs use slug_en when a translation exists (falling back to
     * the Vietnamese slug otherwise, so an untranslated product still gets
     * a working /en/ URL instead of a 404).
     */
    public function getRouteKey()
    {
        if (app()->getLocale() === 'en' && filled($this->slug_en)) {
            return $this->slug_en;
        }

        return $this->slug;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if (app()->getLocale() === 'en') {
            $bySlugEn = static::where('slug_en', $value)->first();

            if ($bySlugEn) {
                return $bySlugEn;
            }
        }

        return static::where('slug', $value)->first();
    }
}
