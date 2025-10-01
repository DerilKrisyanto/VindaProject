<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterJenisPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('jenispegawai_m')->insert([
            ['jenispegawai' => 'Leader', 'statusenabled' => true],
            ['jenispegawai' => 'SPG', 'statusenabled' => true],
        ]);
    }
}
