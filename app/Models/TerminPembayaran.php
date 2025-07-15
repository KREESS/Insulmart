<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'termin_ke',
        'jumlah',
        'status',
        'bukti_pembayaran',
        'tanggal_bayar',
        'tanggal_jatuh_tempo',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'tanggal_bayar' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
