<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_quotation')->unique();
            $table->text('catatan_tambahan')->nullable();
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['pending', 'offered', 'accepted', 'rejected'])->default('pending');
            $table->tinyInteger('termin_count')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
