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

            // Relasi ke tabel users (akun login)
            // onDelete('cascade') artinya jika akun User dihapus, data Guru ikut terhapus
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identitas Pribadi Utama
            $table->string('nip', 25)->unique()->nullable(); // Bisa NIP atau NUPTK
            $table->string('nama_lengkap');
            $table->string('gelar_depan', 15)->nullable();
            $table->string('gelar_belakang', 15)->nullable();

            // Biodata Lanjutan
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('agama', 20);

            // Kontak & Alamat
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();

            // Path untuk menyimpan nama file foto profil
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
