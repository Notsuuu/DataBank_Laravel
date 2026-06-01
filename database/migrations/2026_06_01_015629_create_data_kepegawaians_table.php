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
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->string('status_pegawai'); // PNS, PPPK, Honorer, GTY
            $table->string('golongan')->nullable();
            $table->string('jabatan');
            $table->date('tmt_kerja'); // Terhitung Mulai Tanggal (TMT)
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
