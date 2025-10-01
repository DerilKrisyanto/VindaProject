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
        Schema::create('pegawai_m', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('statusenabled')->default(true);
            $table->string('namalengkap');

            // Foreign key ke pegawai_m
            $table->unsignedBigInteger('jenispegawai_id');
            $table->unsignedBigInteger('objectstatuspegawaifk')->nullable();;
            $table->unsignedBigInteger('userbrand');
            $table->json('toko_id')->nullable();;

            $table->string('no_telepon');
            $table->string('email')->unique();
            $table->string('foto_pegawai')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('jenispegawai_id')->references('id')->on('jenispegawai_m')->onDelete('restrict');
            $table->foreign('userbrand')->references('id')->on('masterbrand_m')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_m');
    }
};
