<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $t) {
            $t->string('po_code', 30)->nullable()->index()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('pembelian_varian_produks', function (Blueprint $t) {
            $t->dropColumn('po_code');
        });
    }
};
