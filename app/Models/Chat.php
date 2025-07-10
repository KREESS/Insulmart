<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $table = 'chats';
    public $timestamps = false; // karena hanya pakai created_at

    protected $fillable = [
        'user_id',
        'guest_id',
        'created_at',
    ];

    // Relasi: Chat punya banyak pesan
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    // Relasi: Chat punya 1 status mengetik
    public function typingStatuses(): HasMany
    {
        return $this->hasMany(TypingStatus::class);
    }

    // (opsional) user yang login
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
