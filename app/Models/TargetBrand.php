<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetBrand extends Model
{
    protected $table = 'targetbrand_t';

    protected $fillable = [
        'nama_event', 'tanggal', 'local_partner', 'nama_media', 'link_media',
        'jumlah_partisipan', 'nama_toko', 'bentuk_kolaborasi', 'detail_kolaborasi',
        'qty_keluar', 'hasil_kolaborasi', 'dokumentasi', 'brand_id', 'pic_id','statusenabled'
    ];

}