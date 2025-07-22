<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('alamat_pengguna', function (Blueprint $table) {
            // Hapus kolom ID wilayah
            $table->dropColumn(['province_id', 'regency_id', 'district_id', 'village_id']);

            // Tambahkan kolom nama wilayah
            $table->string('province')->after('user_id');
            $table->string('regency')->after('province');
            $table->string('district')->after('regency');
            $table->string('village')->after('district');
        });
    }

    public function down(): void
    {
        Schema::table('alamat_pengguna', function (Blueprint $table) {
            // Kembalikan kolom ID
            $table->unsignedBigInteger('province_id')->after('user_id');
            $table->unsignedBigInteger('regency_id')->after('province_id');
            $table->unsignedBigInteger('district_id')->after('regency_id');
            $table->unsignedBigInteger('village_id')->after('district_id');

            // Hapus kolom nama
            $table->dropColumn(['province', 'regency', 'district', 'village']);
        });
    }
};
