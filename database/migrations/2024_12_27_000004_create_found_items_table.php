<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel found_items
     */
    public function up(): void
    {
        Schema::create('found_items', function (Blueprint $table) {

            // Primary key
            $table->id();

            // User yang menemukan barang
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Kategori barang (restrict jika kategori dihapus)
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('restrict');

            // Nama barang
            $table->string('nama_barang');

            // Deskripsi barang
            $table->text('deskripsi');

            // Lokasi ditemukan
            $table->string('lokasi_ditemukan');

            // Tanggal ditemukan
            $table->dateTime('tanggal_ditemukan');

            // Foto barang (opsional)
            $table->string('foto_barang')->nullable();

            // Kontak penemu
            $table->string('kontak_penemu');

            // Status laporan dengan default 'menunggu'
            $table->enum('status', ['menunggu', 'diklaim', 'selesai'])
                  ->default('menunggu');

            // Created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel found_items
     */
    public function down(): void
    {
        Schema::dropIfExists('found_items');
    }
};
