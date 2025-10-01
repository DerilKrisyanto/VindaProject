<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('targettimpromotor_t', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled')->default(true);
            $table->date('bulan');
            $table->unsignedBigInteger('target_id');
            $table->integer('qty_target')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->json('pic_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('target_id')->references('id')->on('daftartargetpromotor_m')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('masterbrand_m')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targettimpromotor_t');
    }
};
