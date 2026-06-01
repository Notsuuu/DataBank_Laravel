<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            // Siapa yang melakukan aksi (opsional/nullable jika by sistem)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('aksi', 20); // Contoh: CREATE, UPDATE, DELETE
            $table->string('entitas', 50); // Contoh: Guru, Siswa, Kelas

            // Kolom JSON untuk menyimpan jejak data
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
