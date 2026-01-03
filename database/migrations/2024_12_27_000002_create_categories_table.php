<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel categories
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {

            // ID unik kategori
            $table->id();

            // Nama kategori (misal "Elektronik")
            $table->string('name');

            // Slug unik untuk URL (misal "elektronik")
            $table->string('slug')->unique();

            // Deskripsi kategori (opsional)
            $table->text('description')->nullable();

            // Icon kategori (opsional, misal "fa-solid fa-tv")
            $table->string('icon')->nullable();

            // Timestamps: created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel categories
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
