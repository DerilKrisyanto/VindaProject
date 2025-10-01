<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('statuspegawai_m')->insert([
            ['statuspegawai' => 'Mobile', 'statusenabled' => true],
            ['statuspegawai' => 'Reguler', 'statusenabled' => true],
        ]);
    }
}
