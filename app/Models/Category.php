<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    public function getNameAttribute($value)
    {
        if (empty($value)) return '';
        if (str_contains($value, 'Óª')) {
            $healed = @iconv('UTF-8', 'CP850//IGNORE', $value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) return $healed;
        }
        if (str_contains($value, 'à¦') || str_contains($value, 'à§')) {
            $healed = @utf8_decode($value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) return $healed;
        }
        return $value;
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
