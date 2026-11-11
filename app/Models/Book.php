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
        'video_url',
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
        return $this->approval_status === 'approved' || ($this->approval_status === null && (bool)$this->is_published);
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

    public function getTitleAttribute($value)
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

    public function getAuthorNameAttribute($value)
    {
        if (empty($value)) return 'মুহম্মদ মুক্তাদির চৌধুরী';
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

    public function getCoverUrlAttribute(): string
    {
        if (!empty($this->cover_image)) {
            return asset(ltrim($this->cover_image, '/'));
        }
        return asset('covers/alor-poth.png');
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        $url = trim($this->video_url);

        // Pattern for standard watch URL, youtu.be, embed, shorts
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        return $url;
    }

    public function hasVideo(): bool
    {
        return !empty($this->video_url) && !empty($this->youtube_embed_url);
    }
}
