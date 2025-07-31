<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'kode_pemesanan',
        'pengguna_id',
        'alamat_pengiriman_id',
        'tanggal_pemesanan',
        'nomor_po',
        'file_po',
        'status_po',
        'status_pemesanan',
        'total_harga',
        'metode_pembayaran',
        'catatan_pelanggan',
    ];

    // Relasi ke user (pengguna)
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    // Relasi ke alamat
    public function alamatPengiriman()
    {
        return $this->belongsTo(AlamatPengguna::class, 'alamat_pengiriman_id');
    }

    // Relasi ke detail produk
    public function detailPemesanan()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasMany(PembayaranPemesanan::class);
    }

    public function armadaPemesanan()
    {
        return $this->hasMany(ArmadaPemesanan::class, 'pemesanan_id');
    }
}
