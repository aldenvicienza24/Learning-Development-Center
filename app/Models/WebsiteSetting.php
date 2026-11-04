<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return static::allAsArray()[$key] ?? $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('website_settings');
    }

    public static function forgetValue(string $key): void
    {
        static::query()->where('key', $key)->delete();
        Cache::forget('website_settings');
    }

    public static function allAsArray(): array
    {
        return Cache::rememberForever('website_settings', fn () => static::query()
            ->pluck('value', 'key')
            ->all());
    }
}
