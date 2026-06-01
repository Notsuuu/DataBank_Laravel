<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users untuk login mandiri
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Identitas Utama
            $table->string('nip', 18)->unique()->nullable(); // Boleh kosong untuk guru honorer
            $table->string('nuptk', 16)->unique()->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
