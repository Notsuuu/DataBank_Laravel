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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 50); // Contoh: "VII A"
            $table->enum('tingkat', ['VII', 'VIII', 'IX']);

            // Relasi ke tabel gurus (sebagai Wali Kelas).
            // nullOnDelete() artinya jika guru dihapus, kelasnya tetap ada tapi wali kelasnya jadi kosong.
            $table->foreignId('wali_kelas_id')->nullable()->constrained('gurus')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
