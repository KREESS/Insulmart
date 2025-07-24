<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VarianProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'tipe',
        'ukuran',
        'ketebalan',
        'densitas',
        'harga',
        'stok',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function detailPemesanan()
    {
        return $this->hasMany(DetailPemesanan::class);
    }
}
