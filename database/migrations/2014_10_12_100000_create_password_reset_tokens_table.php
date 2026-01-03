<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel password_reset_tokens
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {

            // Email pengguna, dijadikan primary key
            $table->string('email')->primary();

            // Token reset password
            $table->string('token');

            // Waktu dibuat token (nullable)
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Rollback migration: hapus tabel password_reset_tokens
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
