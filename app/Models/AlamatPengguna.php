<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatPengguna extends Model
{
    protected $table = 'alamat_pengguna';

    protected $fillable = [
        'user_id',
        'province',
        'regency',
        'district',
        'village',
        'rt',
        'rw',
        'kode_pos',
        'alamat_lengkap',
        'is_default',
        'koordinat',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class, 'alamat_pengiriman_id');
    }

    public function getLatitudeAttribute()
    {
        return explode(',', $this->koordinat)[0] ?? null;
    }

    public function getLongitudeAttribute()
    {
        return explode(',', $this->koordinat)[1] ?? null;
    }

    public function jarakDariGudang(): ?float
    {
        if (!$this->koordinat) return null;

        [$userLat, $userLng] = explode(',', $this->koordinat);
        $gudangLat = -6.1652523499905545;
        $gudangLng = 106.99001484325215;
        $earthRadius = 6371;
        $dLat = deg2rad($userLat - $gudangLat);
        $dLon = deg2rad($userLng - $gudangLng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($gudangLat)) * cos(deg2rad($userLat)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
