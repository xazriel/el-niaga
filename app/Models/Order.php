<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'shipping_cost',
        'grand_total',
        'status',
        'payment_method',
        'payment_token',
        'payment_deadline',
        'shipping_service',
        'tracking_number',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'destination_id',
        'courier_name',
        'service_code',   // ← ditambahkan
        'receiver_city',  // ← ditambahkan
        'receiver_zip',   // ← ditambahkan
        'is_preorder',            // ← tambahkan
        'preorder_release_date',
        'points_earned',          // ← ditambahkan untuk CRM
        'points_redeemed',        // ← ditambahkan untuk CRM
        'points_discount',        // ← ditambahkan untuk CRM
        'voucher_code',           // ← ditambahkan untuk CRM
        'voucher_discount',       // ← ditambahkan untuk CRM
    ];

    protected $casts = [
        'payment_deadline'      => 'datetime',
        'is_preorder'           => 'boolean',
        'preorder_release_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->payment_deadline = Carbon::now()->addHours(2);
            $order->order_number = 'FRH-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeReadyToRelease($query)
    {
        return $query
            ->where('is_preorder', true)
            ->where('status', 'success')
            ->where('preorder_release_date', '<=', now());
    }

    public function isPreorderReleased(): bool
    {
        if (! $this->is_preorder) {
            return true;
        }
        return $this->preorder_release_date
            ? now()->gte($this->preorder_release_date)
            : false;
    }

    public function markAsPaid()
    {
        $paidStatuses = ['success', 'paid', 'shipped', 'completed'];
        if (!in_array($this->status, $paidStatuses)) {
            $rate = (int) \App\Models\Setting::get('loyalty_spend_per_point_rate', 10000);
            $pointsEarned = floor($this->total_amount / $rate);
            
            $this->update([
                'status' => 'success',
                'points_earned' => $pointsEarned
            ]);
            
            if ($pointsEarned > 0 && $this->user) {
                $this->user->adjustPoints($pointsEarned, 'earn', "Poin dari transaksi #{$this->order_number}", $this->id);
            }
        }
    }
    
    public function cancelOrder()
    {
        if ($this->status === 'cancelled') return;
        
        \Illuminate\Support\Facades\DB::transaction(function () {
            $this->update(['status' => 'cancelled']);
            
            // Refund points
            if ($this->points_redeemed > 0 && $this->user) {
                $this->user->adjustPoints($this->points_redeemed, 'refund', "Refund poin dari pembatalan pesanan #{$this->order_number}", $this->id);
            }
            
            // Deduct points earned if already awarded
            if ($this->points_earned > 0 && $this->user) {
                $this->user->adjustPoints(-$this->points_earned, 'refund', "Pemotongan poin dari pembatalan pesanan #{$this->order_number}", $this->id);
            }
            
            if ($this->is_preorder) return;
            
            foreach ($this->items as $item) {
                $variant = ProductVariant::where('product_id', $item->product_id)
                    ->where('color', $item->color)
                    ->where('size', $item->size)
                    ->first();
                if ($variant) {
                    $variant->increment('stock', $item->quantity);
                }
            }
        });
    }
}