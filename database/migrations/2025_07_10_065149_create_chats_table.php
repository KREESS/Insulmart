<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('user_id')->nullable();    // User login (nullable)
            $table->string('guest_id', 100)->nullable();          // Guest ID (cookie/session)
            $table->timestamp('created_at')->useCurrent();        // Waktu dibuat

            // Foreign key ke users.id (nullable)
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null'); // Jika user dihapus, user_id diset NULL
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
