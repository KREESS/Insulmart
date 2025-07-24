<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Tambah kolom nullable setelah 'id'
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('kode_pemesanan', 50)
                ->after('id')
                ->nullable()
                ->comment('Kode unik untuk setiap pemesanan');
        });

        // 2) Isi kode_pemesanan pada data lama
        DB::table('pemesanan')->orderBy('id')->chunkById(100, function ($orders) {
            foreach ($orders as $ord) {
                // contoh: INS20250723 + padded ID => INS202507230001
                $kode = 'INS'
                    . now()->format('Ymd')
                    . str_pad($ord->id, 4, '0', STR_PAD_LEFT);

                DB::table('pemesanan')
                    ->where('id', $ord->id)
                    ->update(['kode_pemesanan' => $kode]);
            }
        });

        // 3) Ubah kolom jadi NOT NULL dan tambahkan unique index
        //   * membutuhkan doctrine/dbal untuk modify column
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('kode_pemesanan', 50)
                ->nullable(false)
                ->change();
            $table->unique('kode_pemesanan');
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropUnique(['kode_pemesanan']);
            $table->dropColumn('kode_pemesanan');
        });
    }
};
