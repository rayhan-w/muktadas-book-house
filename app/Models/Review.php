<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'customer_name',
        'customer_email',
        'rating',
        'comment',
        'is_verified_purchase',
        'status',
    ];

    public function getCommentAttribute($value)
    {
        if (empty($value)) return '';
        if (str_contains($value, 'Óª')) {
            $healed = @iconv('UTF-8', 'CP850//IGNORE', $value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) {
                return $healed;
            }
        }
        if (str_contains($value, 'à¦') || str_contains($value, 'à§')) {
            $healed = @utf8_decode($value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) {
                return $healed;
            }
        }
        return $value;
    }

    public function getCustomerNameAttribute($value)
    {
        if (empty($value)) return 'পাঠক';
        if (str_contains($value, 'Óª')) {
            $healed = @iconv('UTF-8', 'CP850//IGNORE', $value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) {
                return $healed;
            }
        }
        if (str_contains($value, 'à¦') || str_contains($value, 'à§')) {
            $healed = @utf8_decode($value);
            if ($healed && mb_check_encoding($healed, 'UTF-8')) {
                return $healed;
            }
        }
        return $value;
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
