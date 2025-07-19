<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    // Relasi: Satu cart memiliki banyak cart item
    // App\Models\Cart.php
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Relasi: Cart dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
