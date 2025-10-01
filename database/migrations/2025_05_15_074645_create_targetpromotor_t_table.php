<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('targetpromotor_t', function (Blueprint $table) {
            $table->id();
            $table->boolean('statusenabled')->default(true);

            // Foreign key ke masterbrand_m
            $table->unsignedBigInteger('brand_id');

            // Foreign key ke pegawai_m
            $table->unsignedBigInteger('pic_id');

            // Foreign key ke targettimpromotor_t
            $table->unsignedBigInteger('targettim_id');

            // Kolom informasi lainnya
            $table->string('nama_collab')->nullable();
            $table->text('produk')->nullable();
            $table->string('platform')->nullable();
            $table->string('link_konten')->nullable();
            $table->text('ket_tambahan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('targetpromotor_t');
    }
};