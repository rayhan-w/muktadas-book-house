<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author_name',
        'summary',
        'story_behind',
        'publication_year',
        'page_count',
        'price_hardcopy',
        'price_ebook',
        'discount_percent',
        'stock_quantity',
        'stock_status',
        'cover_image',
        'ebook_file',
        'preview_pages',
        'is_featured',
        'is_latest',
        'is_popular',
        'is_upcoming',
        'expected_date',
        'pen_picture',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'user_id',
        'publisher_name',
        'approval_status',
        'rejection_reason',
    ];

    protected $casts = [
        'price_hardcopy' => 'decimal:2',
        'price_ebook' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_latest' => 'boolean',
        'is_popular' => 'boolean',
        'is_upcoming' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_published', true);
    }

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->approval_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->approval_status === 'rejected';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    public function averageRating(): float
    {
        return round((float) $this->approvedReviews()->avg('rating') ?: 5.0, 1);
    }

    public function reviewsCount(): int
    {
        return $this->approvedReviews()->count();
    }

    public function hardcopyEffectivePrice(): float
    {
        if ($this->discount_percent > 0) {
            return round($this->price_hardcopy * (1 - ($this->discount_percent / 100)), 2);
        }
        return (float) $this->price_hardcopy;
    }

    public function ebookEffectivePrice(): float
    {
        if ($this->discount_percent > 0) {
            return round($this->price_ebook * (1 - ($this->discount_percent / 100)), 2);
        }
        return (float) $this->price_ebook;
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && file_exists(public_path($this->cover_image))) {
            return asset($this->cover_image);
        }
        return asset('covers/alor-poth.png');
    }
}
