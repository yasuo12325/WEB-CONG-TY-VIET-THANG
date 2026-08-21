<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('settings.all', function () {
            return static::query()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Locale-aware read: for English, looks up "{$key}_en" and falls back
     * to the Vietnamese "{$key}" value when no translation has been set
     * (settings are managed as plain key/value rows, so a translation is
     * just another row rather than a schema change).
     */
    public static function getTrans(string $key, mixed $default = null): mixed
    {
        if (app()->getLocale() === 'en') {
            $translated = static::get("{$key}_en");

            if (filled($translated)) {
                return $translated;
            }
        }

        return static::get($key, $default);
    }

    public static function set(string $key, mixed $value, string $type = 'string'): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value, 'type' => $type]);
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
