<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'varian_produk_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    public function varianProduk()
    {
        return $this->belongsTo(VarianProduk::class);
    }
}
