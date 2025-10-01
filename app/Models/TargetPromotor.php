<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetPromotor extends Model
{
    use HasFactory;

    protected $table = 'targetpromotor_t';

    protected $fillable = [
        'brand_id',
        'pic_id',
        'targettim_id',
        'nama_collab',
        'produk',
        'platform',
        'link_konten',
        'ket_tambahan',
    ];

    public function brand()
    {
        return $this->belongsTo(MasterBrand::class, 'brand_id');
    }

    public function pic()
    {
        return $this->belongsTo(Pegawai::class, 'pic_id');
    }

    public function targettim()
    {
        return $this->belongsTo(TargetTimPromotor::class, 'targettim_id');
    }
}
