<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmadaPengiriman extends Model
{
    protected $table = 'armada_pengiriman';

    protected $fillable = [
        'nama',
        'kapasitas_pack',
        'tarif_per_km',
    ];
}
