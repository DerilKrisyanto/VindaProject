<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterBrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('masterbrand_m')->insert([
            ['namabrand' => 'Vinda & Tempo', 'statusenabled' => true]
        ]);
    }
}

