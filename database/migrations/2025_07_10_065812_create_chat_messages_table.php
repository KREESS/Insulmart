<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('chat_id'); // Foreign key ke chats
            $table->enum('sender', ['user', 'admin']); // ENUM pengirim
            $table->text('message'); // Isi pesan
            $table->boolean('is_read')->default(false); // Sudah dibaca atau belum
            $table->timestamp('created_at')->useCurrent(); // Waktu kirim

            // Foreign key constraint
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
