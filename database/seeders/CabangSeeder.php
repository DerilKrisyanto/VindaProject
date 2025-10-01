<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cabang_m')->insert([
            ['id' => '1', 'cabang' => 'MAKASSAR', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['id' => '2', 'cabang' => 'KENDARI', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['id' => '3', 'cabang' => 'MANADO', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['id' => '4', 'cabang' => 'PALU', 'objectwilayahfk' => '1', 'statusenabled' => true],
        ]);
    }
}
