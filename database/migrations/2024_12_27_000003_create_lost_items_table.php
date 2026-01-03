<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel lost_items
     */
    public function up(): void
    {
        Schema::create('lost_items', function (Blueprint $table) {

            // Primary key
            $table->id();

            // User yang kehilangan barang
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

            // Lokasi terakhir barang hilang
            $table->string('lokasi_terakhir');

            // Tanggal hilang
            $table->dateTime('tanggal_hilang');

            // Foto barang (opsional)
            $table->string('foto_barang')->nullable();

            // Status laporan: hilang / ditemukan / selesai
            $table->enum('status', ['hilang', 'ditemukan', 'selesai'])
                  ->default('hilang');

            // Created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel lost_items
     */
    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
