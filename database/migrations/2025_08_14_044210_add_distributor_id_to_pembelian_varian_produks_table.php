<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Tambah kolom relasi ke distributors
            $table->foreignId('distributor_id')
                ->nullable()
                ->after('varian_id')
                ->constrained('distributors')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Hapus FK + kolom (shorthand)
            $table->dropConstrainedForeignId('distributor_id');

            // Jika Laravel kamu lama dan method di atas tidak ada, pakai:
            // $table->dropForeign(['distributor_id']);
            // $table->dropColumn('distributor_id');
        });
    }
};
