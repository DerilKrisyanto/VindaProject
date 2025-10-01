<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TargetTimPromotor extends Model
{
    protected $table = 'targettimpromotor_t';

    protected $fillable = [
        'brand_id', 'target_id', 'qty_target', 'bulan', 'pic_id', 'statusenabled',
    ];

    protected $casts = [
        'pic_id' => 'array',
        'bulan' => 'date',
    ];

    public function getPicNamaAttribute() {
        $picIds = is_array($this->pic_id) ? $this->pic_id : json_decode($this->pic_id, true);

        if (empty($picIds)) return null;

        return DB::table('pegawai_m')
            ->whereIn('id', $picIds)
            ->pluck('namalengkap')
            ->implode(', ');
    }

}
