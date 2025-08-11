<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('varian_produks', function (Blueprint $table) {
            $table->string('status_ketersediaan', 50)->nullable()->after('stok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('varian_produks', function (Blueprint $table) {
            $table->dropColumn('status_ketersediaan');
        });
    }
};
