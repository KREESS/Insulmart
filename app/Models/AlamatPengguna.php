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
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}
