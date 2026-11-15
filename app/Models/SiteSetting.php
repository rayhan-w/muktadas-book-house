<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getLogo(): string
    {
        $logo = static::get('site_logo');
        if ($logo) {
            if (file_exists(public_path($logo))) {
                return asset($logo);
            }
            if (file_exists(public_path('uploads/' . $logo))) {
                return asset('uploads/' . $logo);
            }
        }
        if (file_exists(public_path('muktadar-logo.jpg'))) {
            return asset('muktadar-logo.jpg');
        }
        return asset('muktadar-logo.jpg');
    }
}
