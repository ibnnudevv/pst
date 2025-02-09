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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable(); // URL gambar
            $table->string('produk')->unique();
            $table->text('deskripsi')->nullable(); // Deskripsi produk
            $table->integer('stok');
            $table->integer('harga');
            $table->decimal('diskon', 5, 2)->default(0); // Diskon dalam persen
            $table->decimal('rating', 2, 1)->default(0); // Rating produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
