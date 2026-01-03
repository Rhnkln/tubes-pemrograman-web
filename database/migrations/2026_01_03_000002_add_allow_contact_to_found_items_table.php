<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom allow_contact ke tabel found_items
     */
    public function up(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            // Menentukan apakah penemu mengizinkan dihubungi
            $table->boolean('allow_contact')
                  ->default(false)
                  ->after('kontak_penemu');
        });
    }

    /**
     * Menghapus kolom allow_contact dari tabel found_items
     */
    public function down(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            // Rollback: hapus kolom allow_contact
            $table->dropColumn('allow_contact');
        });
    }
};
