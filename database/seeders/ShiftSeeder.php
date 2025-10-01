<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('shift_m')->insert([
            ['shift' => 'Pagi', 'statusenabled' => true],
            ['shift' => 'Middle', 'statusenabled' => true],
            ['shift' => 'Siang', 'statusenabled' => true],
        ]);
    }
}
