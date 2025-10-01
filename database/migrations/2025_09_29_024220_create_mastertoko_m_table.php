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
        Schema::create('mastertoko_m', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('statusenabled')->default(true);
            $table->string('namatoko');
            
            // Foreign key ke cabang_m dan wilayah_m
            $table->unsignedBigInteger('objectcabangfk');
            $table->unsignedBigInteger('objectwilayahfk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mastertoko_m');
    }
};
