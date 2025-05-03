<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_emergency_numbers_table.php
public function up()
{
    Schema::create('emergency_numbers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('emergency_unit_id')->constrained()->onDelete('cascade');
        $table->string('location');
        $table->string('phone_number');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_numbers');
    }
};
