<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'delivery_zone',
        'delivery_charge',
        'delivery_instruction',
        'subtotal',
        'discount',
        'total',
        'payment_method',
        'payment_number',
        'payment_trx_id',
        'payment_status',
        'order_status',
        'courier_tracking_id',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusInBengali(): string
    {
        return match($this->order_status) {
            'pending' => 'পেন্ডিং',
            'payment_verified' => 'পেমেন্ট অনুমোদিত',
            'processing' => 'প্রসেসিং',
            'shipped' => 'শিপড',
            'delivered' => 'ডেলিভারড',
            'cancelled' => 'বাতিল',
            default => $this->order_status,
        };
    }

    public function paymentStatusInBengali(): string
    {
        return match($this->payment_status) {
            'pending' => 'অপেক্ষমাণ',
            'verified' => 'যাচাইকৃত',
            'rejected' => 'প্রত্যাখ্যাত',
            default => $this->payment_status,
        };
    }
}
