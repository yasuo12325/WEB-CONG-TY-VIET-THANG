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
