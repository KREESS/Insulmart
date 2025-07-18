<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'varian_produk_id', 'quantity', 'price', 'subtotal'];

    // Relasi: Cart item dimiliki oleh satu cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relasi: Cart item berhubungan dengan satu varian produk
    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class, 'varian_produk_id');
    }
}
