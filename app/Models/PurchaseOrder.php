<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'nomor_po',
        'file_po_path',
        'tanggal_po',
        'status',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
