<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_quotation',
        'alamat_pengiriman',
        'catatan_tambahan',
        'total_harga',
        'status',
        'termin_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
