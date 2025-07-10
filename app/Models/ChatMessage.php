<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';
    public $timestamps = false; // pakai created_at saja

    protected $fillable = [
        'chat_id',
        'sender',
        'message',
        'is_read',
        'created_at',
    ];

    // Relasi: Pesan milik satu chat
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
