<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mastertoko_m')->insert([
            //MAKASSAR
            ['namatoko' => 'SATU SAMA PERINTIS', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'OLALA PERINTIS', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'GRAND MALL MAROS', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'DIAMOND PANAKUKKANG', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'MISIPASARAYA BARUGA', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'MISIPASARAYA ANTANG', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'GRAND TOSERBA PENGAYOMAN', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'CITRA PERINTIS', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'BAJI PAMAI RANGGONG', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'GRAND TOSERBA TANJUNG', 'objectcabangfk' => '1', 'objectwilayahfk' => '1', 'statusenabled' => true],

            //KENDARI
            ['namatoko' => 'SANYA MART', 'objectcabangfk' => '2', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'MARINA SWALAYAN', 'objectcabangfk' => '2', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'SANYA SWALAYAN', 'objectcabangfk' => '2', 'objectwilayahfk' => '1', 'statusenabled' => true],

            //MANADO
            ['namatoko' => 'GOLDEN MIP', 'objectcabangfk' => '3', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'LOSS GROSIR', 'objectcabangfk' => '3', 'objectwilayahfk' => '1', 'statusenabled' => true],

            //PALU
            ['namatoko' => 'GRAND HERO', 'objectcabangfk' => '4', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'BUMI NYIUR SWALAYAN', 'objectcabangfk' => '4', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'AS FROZEN GARUDA', 'objectcabangfk' => '4', 'objectwilayahfk' => '1', 'statusenabled' => true],
            ['namatoko' => 'AS FROZEN LALOVE', 'objectcabangfk' => '4', 'objectwilayahfk' => '1', 'statusenabled' => true],
        ]);
    }
}
