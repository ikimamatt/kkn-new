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
                $table->unsignedBigInteger('family_card_id')->nullable();
                $table->foreign('family_card_id')->references('id')->on('family_cards')->onDelete('cascade');
                $table->string('name');
                $table->string('email')->unique()->nullable();
                $table->string('password')->nullable();
                $table->enum('role', ['warga', 'administrator', 'superadmin']);
                $table->string('nik')->unique();
                $table->date('tanggal_lahir');
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->string('tempat_lahir');
                $table->string('jenis_pekerjaan');
                $table->string('golongan_darah', 3)->nullable();
                $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai']);
                $table->date('tanggal_perkawinan_atau_perceraian')->nullable();
                $table->enum('status_hubungan_keluarga', ['kepala_keluarga', 'istri', 'anak'])->nullable();
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
