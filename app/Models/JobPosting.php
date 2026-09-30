<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobPosting extends Model
{
    use HasTranslatedFields, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected array $translatable = ['title', 'location', 'excerpt', 'body'];

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'slug_en',
        'location',
        'location_en',
        'excerpt',
        'excerpt_en',
        'body',
        'body_en',
        'deadline',
        'cover_image_path',
        'status',
        'published_at',
        'author_id',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'deadline' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (JobPosting $job) {
            if (blank($job->slug)) {
                $job->slug = Str::slug($job->title);
            }

            if (filled($job->title_en) && blank($job->slug_en)) {
                $job->slug_en = Str::slug($job->title_en);
            }

            if ($job->status === self::STATUS_PUBLISHED && blank($job->published_at)) {
                $job->published_at = now();
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
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
