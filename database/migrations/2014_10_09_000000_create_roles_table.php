<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel roles
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {

            // Primary key
            $table->id();

            // Nama role (unik)
            $table->string('name')->unique();

            // Deskripsi role (opsional)
            $table->string('description')->nullable();

            // Created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Rollback migration: hapus tabel roles
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
