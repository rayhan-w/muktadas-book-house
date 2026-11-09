<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_spend',
        'valid_until',
        'usage_limit',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function isValidForAmount(float $amount): bool
    {
        if (!$this->is_active) return false;
        if ($this->valid_until && $this->valid_until->isPast()) return false;
        if ($this->usage_limit && $this->times_used >= $this->usage_limit) return false;
        if ($amount < $this->min_spend) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percent') {
            return round($amount * ($this->discount_value / 100), 2);
        }
        return min((float) $this->discount_value, $amount);
    }
}
