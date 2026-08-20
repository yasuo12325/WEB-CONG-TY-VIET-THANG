<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductDocument extends Model
{
    protected $fillable = [
        'product_id',
        'disk',
        'path',
        'original_filename',
        'label',
        'file_size',
        'mime_type',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted(): void
    {
        static::deleted(function (ProductDocument $document) {
            Storage::disk($document->disk)->delete($document->path);
        });
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
