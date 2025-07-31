<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmadaPemesanan extends Model
{
    protected $table = 'armada_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'armada_id',
        'jumlah_mobil',
        'jarak_km',
        'subtotal_ongkir',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function armada()
    {
        return $this->belongsTo(ArmadaPengiriman::class);
    }
}
