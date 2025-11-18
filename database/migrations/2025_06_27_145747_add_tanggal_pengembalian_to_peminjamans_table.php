<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalPengembalianToPeminjamansTable extends Migration
{
    public function up()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->date('tanggal_pengembalian')->nullable()->after('tanggal_kembali');
        });
    }

    public function down()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengembalian');
        });
    }
}
