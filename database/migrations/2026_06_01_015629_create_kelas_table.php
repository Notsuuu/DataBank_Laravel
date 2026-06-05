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
            $table->string('tingkat_kelas'); // Contoh: "VII", "VIII", "IX"
            $table->string('nama_kelas'); // Contoh: "VII-A", "VII-B"

            // Relasi ke tabel gurus untuk Wali Kelas.
            // Pakai nullOnDelete agar kalau guru dihapus, kelasnya tidak ikut terhapus (hanya wali kelasnya jadi kosong).
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->nullOnDelete();

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
