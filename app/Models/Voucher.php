<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_spend', 'is_active', 'expires_at', 'points_cost'];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function isValidFor($amount)
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($amount < $this->min_spend) return false;
        return true;
    }

    public function getDiscountAmount($subtotal)
    {
        if ($this->type === 'percent') {
            return ($this->value / 100) * $subtotal;
        }
        return min($this->value, $subtotal);
    }
}
