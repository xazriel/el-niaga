<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',            // Tambahkan ini
        'address',          // Tambahkan ini
        'destination_id',   // Tambahkan ini
        'destination_name', // Tambahkan ini
        'points',           // Tambahkan ini untuk CRM
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(UserAddress::class)->where('is_default', true);
    }

    public function orders()
    {
        // Pastikan mengarah ke model Order yang sudah kamu buat tadi
        return $this->hasMany(Order::class);
    }

    public function loyaltyTransactions(): HasMany
    {
        return $this->hasMany(LoyaltyPointTransaction::class);
    }

    public function adjustPoints($amount, $type, $description, $orderId = null)
    {
        $this->points += $amount;
        $this->save();

        return $this->loyaltyTransactions()->create([
            'order_id' => $orderId,
            'points' => $amount,
            'type' => $type,
            'description' => $description,
        ]);
    }

}
