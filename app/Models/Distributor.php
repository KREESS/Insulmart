<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distributor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_pt',
        'contact_person',
        'phone',
        'email',
        'npwp',
        'province',
        'regency',
        'district',
        'village',
        'rt',
        'rw',
        'kode_pos',
        'alamat_lengkap',
        'coordinate',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
