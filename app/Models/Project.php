<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasTranslatedFields, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected array $translatable = ['title', 'summary', 'body'];

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'slug_en',
        'client_name',
        'summary',
        'summary_en',
        'body',
        'body_en',
        'cover_image_path',
        'status',
        'completed_year',
    ];

    protected static function booted(): void
    {
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $project->slug = Str::slug($project->title);
            }

            if (filled($project->title_en) && blank($project->slug_en)) {
                $project->slug_en = Str::slug($project->title_en);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
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
