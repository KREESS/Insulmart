<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'jenis_produk',
        'deskripsi',
    ];

    public function varians()
    {
        return $this->hasMany(VarianProduk::class, 'produk_id');
    }

    public function gambars()
    {
        return $this->hasMany(ProdukGambar::class, 'produk_id');
    }

    public function getSlugifiedNamaAttribute()
    {
        // Hilangkan semua karakter kecuali huruf, angka, dan spasi
        $cleaned = preg_replace('/[^A-Za-z0-9 ]+/', '', $this->nama_produk);

        // Normalize spasi berlebih
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        // Buat slug dari hasil bersih
        return Str::slug($cleaned, '-');
    }
}
