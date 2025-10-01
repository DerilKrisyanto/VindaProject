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
        Schema::create('daftartargetpromotor_m', function (Blueprint $table) {
            $table->id();
            $table->string('nama_target');
            $table->boolean('statusenabled')->default(true);
            $table->unsignedBigInteger('brand_id');
            $table->json('pic_id');
            $table->timestamps();

            // Foreign key opsional
            $table->foreign('brand_id')->references('id')->on('masterbrand_m')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftartargetpromotor_m');
    }
};
