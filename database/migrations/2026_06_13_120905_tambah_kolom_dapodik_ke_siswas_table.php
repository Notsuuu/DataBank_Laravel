<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nik', 20)->nullable()->after('nisn');
            $table->string('no_hp_siswa', 20)->nullable()->after('agama');
            
            $table->string('rt', 5)->nullable()->after('alamat');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kode_pos', 10)->nullable()->after('kecamatan');

            $table->string('nama_ayah')->nullable()->after('kode_pos');
            $table->string('pekerjaan_ayah')->nullable()->after('nama_ayah');
            $table->string('nama_ibu')->nullable()->after('pekerjaan_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_hp_siswa', 'rt', 'rw', 'kelurahan', 'kecamatan', 
                'kode_pos', 'nama_ayah', 'pekerjaan_ayah', 'nama_ibu', 'pekerjaan_ibu'
            ]);
        });
    }
};