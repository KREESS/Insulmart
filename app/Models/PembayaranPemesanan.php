<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPemesanan extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'termin_ke',
        'jumlah_dibayar',
        'tanggal_pembayaran',
        'status_verifikasi',
        'bukti_transfer',
        'catatan_admin',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
