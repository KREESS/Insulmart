<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('distributors', function (Blueprint $t) {
            $t->id();
            $t->string('name_pt', 150);
            $t->string('contact_person', 150)->nullable();
            $t->string('phone', 50)->nullable();
            $t->string('email', 150)->nullable();
            $t->string('province', 100)->nullable();
            $t->string('regency', 100)->nullable();
            $t->string('district', 100)->nullable();
            $t->string('village', 100)->nullable();
            $t->string('rt', 5)->nullable();
            $t->string('rw', 5)->nullable();
            $t->string('kode_pos', 10)->nullable();
            $t->text('alamat_lengkap')->nullable();
            $t->text('notes')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
