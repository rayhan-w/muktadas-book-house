<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookLibrary extends Model
{
    use HasFactory;

    protected $table = 'ebook_libraries';

    protected $fillable = [
        'user_id',
        'book_id',
        'order_id',
        'last_read_page',
        'access_granted_at',
    ];

    protected $casts = [
        'access_granted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
