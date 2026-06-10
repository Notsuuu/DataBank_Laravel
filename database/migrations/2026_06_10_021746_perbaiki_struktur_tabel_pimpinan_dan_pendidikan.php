<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom berkas ke tabel pimpinans
        Schema::table('pimpinans', function (Blueprint $table) {
            if (!Schema::hasColumn('pimpinans', 'foto')) {
                $table->string('foto')->nullable();
                $table->string('file_ktp')->nullable();
                $table->string('file_ijazah')->nullable();
                $table->string('file_sk')->nullable();
            }
        });

        // 2. Perbaiki tabel riwayat_pendidikans agar mendukung Pimpinan
        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            // Jadikan guru_id BISA KOSONG (nullable) agar Pimpinan tidak diwajibkan punya guru_id
            $table->unsignedBigInteger('guru_id')->nullable()->change();

            // Tambahkan kolom pimpinan_id jika belum ada
            if (!Schema::hasColumn('riwayat_pendidikans', 'pimpinan_id')) {
                $table->foreignId('pimpinan_id')->nullable()->constrained('pimpinans')->cascadeOnDelete()->after('guru_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pimpinans', function (Blueprint $table) {
            $table->dropColumn(['foto', 'file_ktp', 'file_ijazah', 'file_sk']);
        });

        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            $table->dropForeign(['pimpinan_id']);
            $table->dropColumn('pimpinan_id');
        });
    }
};
