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
        Schema::create('armada_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kapasitas_pack');
            $table->integer('tarif_per_km');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('armada_pengiriman');
    }
};
