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
        Schema::create('targetbrand_t', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('statusenabled')->default(true);
            $table->string('nama_event');
            $table->dateTime('tanggal');
            $table->string('local_partner')->nullable();
            $table->string('nama_media')->nullable();
            $table->string('link_media')->nullable();
            $table->integer('jumlah_partisipan')->nullable();
            $table->string('nama_toko')->nullable();
            $table->string('bentuk_kolaborasi')->nullable();
            $table->string('detail_kolaborasi')->nullable();
            $table->integer('qty_keluar')->nullable();
            $table->integer('hasil_kolaborasi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('pic_id');
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targetbrand_t');
    }
};
