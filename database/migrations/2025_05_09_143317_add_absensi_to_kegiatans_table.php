<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('kegiatans', 'absensi')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->json('absensi')->nullable();
            });
        }
    }
    
    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn('absensi');
        });
    }
    
};
