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
        Schema::create('riwayat_pendidikans', function (Blueprint $table) {
            $table->id();

            // Relasi ke Guru. Jika data guru dihapus, riwayatnya ikut terhapus (cascade)
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');

            $table->string('jenjang', 10); // Contoh: SMA, D3, S1, S2
            $table->string('institusi'); // Contoh: Universitas Tadulako
            $table->string('jurusan'); // Contoh: Teknik Informatika
            $table->year('tahun_lulus');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikans');
    }
};
