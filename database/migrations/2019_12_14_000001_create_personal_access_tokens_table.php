<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel personal_access_tokens
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {

            // ID unik token
            $table->id();

            // Polimorfik: user atau model lain yang memiliki token
            $table->morphs('tokenable');

            // Nama token (misal "API Token")
            $table->string('name');

            // Nilai token unik (hash atau plain text)
            $table->string('token', 64)->unique();

            // Kemampuan/permissions token (opsional)
            $table->text('abilities')->nullable();

            // Waktu terakhir token digunakan (opsional)
            $table->timestamp('last_used_at')->nullable();

            // Waktu kadaluarsa token (opsional)
            $table->timestamp('expires_at')->nullable();

            // Timestamps: created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel personal_access_tokens
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
