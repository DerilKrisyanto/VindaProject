<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarTargetPromotor extends Model
{
    protected $table = 'daftartargetpromotor_m';

    protected $fillable = ['nama_target', 'statusenabled', 'brand_id','pic_id'];
}
