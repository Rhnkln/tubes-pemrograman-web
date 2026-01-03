<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel failed_jobs
     */
    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {

            // ID unik untuk setiap job yang gagal
            $table->id();

            // UUID unik job
            $table->string('uuid')->unique();

            // Koneksi yang digunakan job
            $table->text('connection');

            // Nama queue
            $table->text('queue');

            // Payload job yang gagal (data serialized)
            $table->longText('payload');

            // Exception/error message dari job
            $table->longText('exception');

            // Waktu job gagal, otomatis diisi saat insert
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Rollback migration: hapus tabel failed_jobs
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
