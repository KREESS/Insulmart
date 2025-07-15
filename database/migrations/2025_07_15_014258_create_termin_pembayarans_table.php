<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('termin_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('termin_ke'); // 1, 2, atau 3
            $table->decimal('jumlah', 15, 2);
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->string('bukti_pembayaran')->nullable(); // path file upload
            $table->date('tanggal_bayar')->nullable();
            $table->date('tanggal_jatuh_tempo');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('termin_pembayarans');
    }
};
