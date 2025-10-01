<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalkerjaMTable extends Migration
{
    public function up()
    {
        Schema::create('jadwalkerja_m', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('statusenabled')->default(true);
            $table->unsignedBigInteger('objectpegawaifk'); // relasi ke pegawai_m (SPG)
            $table->unsignedBigInteger('objecttokofk');    // relasi ke mastertoko_m
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('tanggal');
            $table->unsignedBigInteger('objectshiftfk'); // relasi ke shift_m
            $table->unsignedBigInteger('objectwilayahfk'); // relasi ke wilayah_m
            $table->unsignedBigInteger('objectcabangfk'); // relasi ke cabang_m
            $table->unsignedBigInteger('objecteventfk'); // relasi ke masterbrand_m
            $table->string('jenis')->nullable();
            $table->unsignedBigInteger('objectstatusfk'); // relasi ke statuspegawai_m
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwalkerja_m');
    }
}

