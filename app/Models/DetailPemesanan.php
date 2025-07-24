<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'varian_produk_id',
        'kuantitas',
        'harga_satuan',
        'subtotal',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }
}
