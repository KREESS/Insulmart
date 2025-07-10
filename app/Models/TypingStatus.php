<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypingStatus extends Model
{
    protected $table = 'typing_status';
    public $timestamps = false; // pakai updated_at manual

    protected $fillable = [
        'chat_id',
        'typing_by',
        'is_typing',
        'updated_at',
    ];

    // Relasi: status mengetik milik satu chat
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
