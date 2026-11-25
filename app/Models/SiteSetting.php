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

    public static function getBanner(): string
    {
        $banner = static::get('hero_banner');
        if ($banner) {
            if (file_exists(public_path($banner))) {
                return asset($banner);
            }
            if (file_exists(public_path('uploads/' . $banner))) {
                return asset('uploads/' . $banner);
            }
        }
        return asset('muktadar-hero-banner.jpg');
    }

    public static function getBgMusic(): ?string
    {
        $music = static::get('bg_music');
        if ($music && static::get('bg_music_enabled', '0') === '1') {
            if (file_exists(public_path($music))) {
                return asset($music);
            }
            if (file_exists(public_path('uploads/' . $music))) {
                return asset('uploads/' . $music);
            }
        }
        return null;
    }
}
