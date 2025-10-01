<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterTargetBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('targetbrand_t')->insert([
            ['statusenabled' => true, 'nama_event' => 'Beauty Class Bebby Makeup', 'tanggal' => '2025-04-22 13:00:00', 'local_partner' => 'Mall Pipo', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/09/beauty-class-di-pipo-mall-cantik-alami-bersama-bebby-makeup',
            'jumlah_partisipan' => '30', 'nama_toko' => 'Citra Perintis', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '2'],

            ['statusenabled' => true, 'nama_event' => 'Beauty Class Sucofindo', 'tanggal' => '2025-04-23 13:00:00', 'local_partner' => 'Kantor Sucofindo', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/09/beauty-class-di-pipo-mall-cantik-alami-bersama-bebby-makeup',
            'jumlah_partisipan' => '25', 'nama_toko' => 'Citra Boulevard ', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '4'],

            ['statusenabled' => true, 'nama_event' => 'Beauty Class Bpjs Kesehatan', 'tanggal' => '2025-04-26 13:00:00', 'local_partner' => 'Kantor Bpjs Kesehatan', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/09/anggun-dan-profesional-beauty-class-bpjs-kesehatan-angkat-tema-office-look',
            'jumlah_partisipan' => '30', 'nama_toko' => 'Citra Boulevard', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '3'],

            ['statusenabled' => true, 'nama_event' => 'Collab With Lv Project', 'tanggal' => '2025-04-29 13:00:00', 'local_partner' => 'Mall Pipo', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/11/make-over-x-lv-project-hadirkan-kelas-make-up-bertema-natural-look-di-pipo-mall',
            'jumlah_partisipan' => '35', 'nama_toko' => 'Citra Arif Rate', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '3'],

            ['statusenabled' => true, 'nama_event' => 'Make Over Take Over Coffe Shop', 'tanggal' => '2025-04-28 13:00:00', 'local_partner' => 'Nuiz Cafe', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/11/make-over-take-over-nuiz-cafe-serbu-promo-diskon-hingga-30-persen',
            'jumlah_partisipan' => '10', 'nama_toko' => 'Citra Boulevard', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '2'],

            ['statusenabled' => true, 'nama_event' => 'Beauty Demo Via Zoom Bpjs Mamuju', 'tanggal' => '2025-04-28 13:00:00', 'local_partner' => 'Zoom Meeting', 'nama_media' => 'Tribun News', 'link_media' => 'https://makassar.tribunnews.com/2025/05/11/beauty-demo-bpjs-kesehatan-mamuju-hadirkan-office-look-lewat-zoom',
            'jumlah_partisipan' => '15', 'nama_toko' => 'Citra Boulevard', 'bentuk_kolaborasi' => 'Voucher', 'detail_kolaborasi' => 'Diskon up to 30%', 'qty_keluar' => '1', 
            'hasil_kolaborasi' => '149000', 'dokumentasi' => '', 'brand_id' => '1', 'pic_id' => '4'],
        ]);
    }
}
