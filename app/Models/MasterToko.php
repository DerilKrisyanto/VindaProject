<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterToko extends Model
{
    protected $table = 'mastertoko_m';

    protected $fillable = ['namatoko', 'statusenabled', 'objectcabangfk', 'objectwilayahfk'];

    public $timestamps = true;

    public function wilayah() {
        return $this->belongsTo(Wilayah::class, 'objectwilayahfk');
    }
    public function cabang() {
        return $this->belongsTo(Cabang::class, 'objectcabangfk');
    }


}