<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(ProdukGambar::class);
    }
}
