<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'total',
        'status',
    ];

    /**
     * Define an inverse one-to-one or many relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'price', 'shipping_cost', 'discount_amount'])
            ->withTimestamps();
    }

}
