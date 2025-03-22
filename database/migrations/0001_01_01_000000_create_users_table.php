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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['superadmin', 'administrator', 'warga']);
                $table->string('nik')->unique();  // Nomor Induk Kependudukan
                $table->date('tanggal_lahir');
                $table->enum('jenis_kelamin', ['L', 'P']);  // L = Laki-laki, P = Perempuan
                $table->string('tempat_lahir');
                $table->string('jenis_pekerjaan');
                $table->string('golongan_darah', 3)->nullable();  // O, A, B, AB
                $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai']);  // Status perkawinan
                $table->date('tanggal_perkawinan_atau_perceraian')->nullable();  // Tanggal perkawinan atau perceraian
                $table->enum('status_hubungan_keluarga', ['kepala_keluarga', 'istri', 'anak'])->nullable();  // Kepala keluarga, Istri, Anak
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
