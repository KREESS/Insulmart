<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatQuotation extends Model
{
    use HasFactory;

    protected $table = 'alamat_quotation';

    protected $fillable = [
        'quotation_id',
        'nama_penerima',
        'jalan',
        'kota',
        'kode_pos',
        'negara',
        'telepon',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
