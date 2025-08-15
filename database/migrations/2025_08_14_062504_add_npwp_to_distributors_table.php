<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('distributors', function (Blueprint $table) {
            // NPWP biasanya 15 digit dengan tanda baca (contoh: 12.345.678.9-012.345)
            // pakai panjang 32 agar aman untuk format ber-spasi/tanda baca
            $table->string('npwp', 32)->nullable()->after('email');
            // Kalau mau wajib unik, aktifkan baris di bawah:
            // $table->unique('npwp');
        });
    }

    public function down(): void
    {
        Schema::table('distributors', function (Blueprint $table) {
            // Hapus index unik dulu jika sebelumnya diaktifkan
            // if (Schema::hasColumn('distributors', 'npwp')) {
            //     $table->dropUnique(['npwp']);
            // }
            $table->dropColumn('npwp');
        });
    }
};
