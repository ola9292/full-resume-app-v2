<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'stripe_charge_id',
        'amount',
        'currency',
        'status',
        'paid_at',
        'expires_at',
        'access_days'
    ];
    protected $casts = [
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if payment is still active
    public function isActive()
    {
        return $this->status === 'succeeded' && $this->expires_at > now();
    }

    // Get days remaining
    public function daysRemaining()
    {
        if (!$this->isActive()) {
            return 0;
        }

        return now()->diffInDays($this->expires_at, false);
    }
}
