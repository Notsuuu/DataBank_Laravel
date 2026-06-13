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
        Schema::table('pimpinans', function (Blueprint $table) {
            $table->string('pangkat_gol', 50)->nullable()->after('nip');
            $table->string('jabatan', 100)->nullable()->after('pangkat_gol');
            $table->string('status_pegawai', 50)->nullable()->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pimpinans', function (Blueprint $table) {
            $table->dropColumn(['pangkat_gol', 'jabatan', 'status_pegawai']);
        });
    }
};
