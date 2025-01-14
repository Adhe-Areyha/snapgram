<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('albums', function (Blueprint $table) {
            $table->id('albumID');
            $table->string('NamaAlbum');
            $table->text('deskripsi')->nullable;
            $table->date('tanggalDibuat');
            $table->foreignId('userID')
            ->constrained('users', 'userID')->onDelete('cascade');
            $table->timestamps();
        });
    }// migration addalah fungsi untuk menghubungkan env laravel dan migrasi ke database

    public function down(): void {
        Schema::dropIfExists('albums');
    }

};
