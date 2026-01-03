<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel messages
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {

            // Primary key
            $table->id();

            // Pengirim pesan
            $table->unsignedBigInteger('from_user_id');

            // Penerima pesan
            $table->unsignedBigInteger('to_user_id');

            // Relasi ke barang temuan (opsional)
            $table->unsignedBigInteger('found_item_id')->nullable();

            // Relasi ke barang kehilangan (opsional)
            $table->unsignedBigInteger('lost_item_id')->nullable();

            // Isi pesan
            $table->text('content');

            // Created_at & Updated_at
            $table->timestamps();

            // Foreign key ke tabel users (pengirim)
            $table->foreign('from_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Foreign key ke tabel users (penerima)
            $table->foreign('to_user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Menghapus tabel messages (rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
