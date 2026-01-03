<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel reports
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {

            // Primary key
            $table->id();

            // Relasi ke tabel lost_items (opsional)
            $table->foreignId('lost_item_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // Relasi ke tabel found_items (opsional)
            $table->foreignId('found_item_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            // User yang membuat laporan
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Judul laporan
            $table->string('judul');

            // Keterangan / deskripsi laporan
            $table->text('keterangan');

            // Tipe laporan: kehilangan / penemuan
            $table->enum('tipe', ['kehilangan', 'penemuan']);

            // Status laporan dengan default 'pending'
            $table->enum('status', ['pending', 'diproses', 'terselesaikan', 'ditolak'])
                  ->default('pending');

            // Tanggal laporan dibuat
            $table->dateTime('tanggal_laporan');

            // Created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel reports
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
