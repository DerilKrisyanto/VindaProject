<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan semua seeder di sini
        $this->call([
            MasterBrandSeeder::class,
            MasterJenisPegawaiSeeder::class,
            DaftarPromotorSeeder::class,
            MasterTargetBrandSeeder::class,
            WilayahSeeder::class,
            CabangSeeder::class,
            MasterTokoSeeder::class,
            StatusPegawaiSeeder::class,
        ]);
    }
}
