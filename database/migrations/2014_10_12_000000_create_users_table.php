<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel users
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // Primary key
            $table->id();

            // Nama pengguna
            $table->string('name');

            // Email pengguna (unik)
            $table->string('email')->unique();

            // Timestamp verifikasi email (nullable)
            $table->timestamp('email_verified_at')->nullable();

            // Password pengguna
            $table->string('password');

            // Nomor telepon (opsional)
            $table->string('phone')->nullable();

            // NIM pengguna (unik dan opsional)
            $table->string('nim')->unique()->nullable();

            // Alamat pengguna (opsional)
            $table->text('alamat')->nullable();

            // Foto profil (opsional)
            $table->string('foto_profil')->nullable();

            // Role pengguna, foreign key ke tabel roles (nullable)
            $table->foreignId('role_id')
                  ->nullable()
                  ->constrained('roles')
                  ->onDelete('set null');

            // Token untuk "remember me"
            $table->rememberToken();

            // Created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel users
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
