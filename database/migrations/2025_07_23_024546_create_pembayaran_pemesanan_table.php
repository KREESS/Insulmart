<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayaran_pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanan')->onDelete('cascade');

            $table->integer('termin_ke');
            $table->decimal('jumlah_dibayar', 15, 2);
            $table->dateTime('tanggal_pembayaran')->nullable();

            $table->enum('status_verifikasi', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('bukti_transfer')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            $table->unique(['pemesanan_id', 'termin_ke']); // untuk menghindari duplikat termin
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pemesanan');
    }
};
