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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            // Berbeda dengan Guru, Siswa biasanya tidak butuh login di sistem informasi akademik dasar
            // Jadi kita tidak perlu menghubungkannya dengan tabel users (kecuali nanti ada portal khusus siswa)

            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('agama', 20);
            $table->text('alamat')->nullable();

            // Data Orang Tua/Wali (untuk keperluan darurat/akademik)
            $table->string('nama_wali')->nullable();
            $table->string('no_hp_wali', 15)->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
