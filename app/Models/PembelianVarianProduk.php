<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianVarianProduk extends Model
{
    protected $table = 'pembelian_varian_produks';

    protected $fillable = [
        'po_code',
        'varian_id',
        'distributor_id',
        'qty',
        'harga_satuan',
        'total_harga',
        'status',
        'tanggal_beli',
        'catatan',
    ];

    protected $casts = [
        'tanggal_beli' => 'datetime',
        'qty' => 'integer',
        'harga_satuan' => 'integer',
        'total_harga' => 'integer',
    ];

    /**
     * Relasi ke VarianProduk
     */
    public function varian()
    {
        return $this->belongsTo(VarianProduk::class, 'varian_id');
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }

    /**
     * Hitung total harga otomatis
     */
    public function setTotalHargaAttribute($value)
    {
        $this->attributes['total_harga'] = $this->qty * $this->harga_satuan;
    }
}
