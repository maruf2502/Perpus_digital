<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
   // Schema::table('bukus', function (Blueprint $table) {
        //$table->string('kategori')->after('tahun_terbit');
   // });
    }

    public function down()
    {
    Schema::table('bukus', function (Blueprint $table) {
        $table->dropColumn('kategori');
    });
    }

};
