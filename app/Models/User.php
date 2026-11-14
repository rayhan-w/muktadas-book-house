<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'membership_plan',
        'membership_expires_at',
        'publisher_company',
        'publisher_status',
        'publisher_bio',
        'publisher_rejection_reason',
        'publisher_plan',
        'publisher_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_expires_at' => 'datetime',
            'publisher_expires_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    public function isPublisher(): bool
    {
        return $this->role === 'publisher';
    }

    public function isApprovedPublisher(): bool
    {
        if (!$this->isPublisher() || $this->publisher_status !== 'approved') {
            return false;
        }
        if ($this->publisher_expires_at && $this->publisher_expires_at->isPast()) {
            return false;
        }
        return true;
    }

    public function isExpiredPublisher(): bool
    {
        return $this->isPublisher() && 
               $this->publisher_status === 'approved' && 
               $this->publisher_expires_at && 
               $this->publisher_expires_at->isPast();
    }

    public function isPendingPublisher(): bool
    {
        return $this->isPublisher() && $this->publisher_status === 'pending';
    }

    public function isRejectedPublisher(): bool
    {
        return $this->isPublisher() && $this->publisher_status === 'rejected';
    }

    public function publisherBooks()
    {
        return $this->hasMany(Book::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function library()
    {
        return $this->hasMany(EbookLibrary::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    public function hasActiveMembership(): bool
    {
        return $this->membership_expires_at && $this->membership_expires_at->isFuture();
    }
}
