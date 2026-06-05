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
        Schema::create('data_kepegawaians', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel gurus
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');

            $table->string('status_pegawai', 20);
            $table->string('nip', 25)->nullable();
            $table->string('golongan', 10)->nullable();
            $table->string('jabatan', 50);
            $table->string('sk_pengangkatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kepegawaians');
    }
};
