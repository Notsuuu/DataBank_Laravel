<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            $table->foreignId('guru_id')->nullable()->change(); // Ubah guru_id jadi nullable
            $table->foreignId('pimpinan_id')->nullable()->constrained('pimpinans')->cascadeOnDelete()->after('guru_id');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pendidikans', function (Blueprint $table) {
            //
        });
    }
};
