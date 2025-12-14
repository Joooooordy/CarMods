<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Relatie met User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relatie met Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
