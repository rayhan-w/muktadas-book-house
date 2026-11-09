<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'duration_months',
        'price',
        'discount_percent',
        'free_ebooks_count',
        'benefits',
        'is_active',
    ];
}
