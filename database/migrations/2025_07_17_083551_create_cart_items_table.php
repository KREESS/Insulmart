<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // Foreign key untuk cart
            $table->foreignId('varian_produk_id')->constrained('varian_produks')->onDelete('cascade'); // Foreign key untuk varian produk
            $table->integer('quantity')->default(1); // Jumlah produk
            $table->decimal('price', 10, 2); // Harga satuan produk
            $table->decimal('subtotal', 10, 2); // Subtotal produk (harga x quantity)
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
