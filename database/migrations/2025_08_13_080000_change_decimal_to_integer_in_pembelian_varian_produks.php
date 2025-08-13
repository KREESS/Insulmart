<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn(['qty', 'harga_satuan', 'total_harga']);
        });

        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Recreate columns as integer
            $table->integer('qty')->after('varian_id');
            $table->integer('harga_satuan')->default(0)->after('qty');
            $table->integer('total_harga')->default(0)->after('harga_satuan');
        });
    }

    public function down(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Drop integer columns
            $table->dropColumn(['qty', 'harga_satuan', 'total_harga']);
        });

        Schema::table('pembelian_varian_produks', function (Blueprint $table) {
            // Restore decimal columns
            $table->decimal('qty', 18, 3)->after('varian_id');
            $table->decimal('harga_satuan', 18, 2)->default(0)->after('qty');
            $table->decimal('total_harga', 18, 2)->default(0)->after('harga_satuan');
        });
    }
};
