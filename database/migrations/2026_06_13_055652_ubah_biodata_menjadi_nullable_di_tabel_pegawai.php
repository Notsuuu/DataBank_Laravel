<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });

        Schema::table('pimpinans', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('agama')->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('agama')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
        });

        Schema::table('pimpinans', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('agama')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
        });
    }
};