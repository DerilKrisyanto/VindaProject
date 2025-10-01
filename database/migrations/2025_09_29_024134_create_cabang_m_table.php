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
        Schema::create('cabang_m', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('statusenabled')->default(true);
            $table->string('cabang');
            // Foreign key ke wilayah_m
            $table->unsignedBigInteger('objectwilayahfk');
            $table->timestamps();

            // Foreign key constraints
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang_m');
    }
};
