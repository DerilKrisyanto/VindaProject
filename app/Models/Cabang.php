<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang_m';
    protected $fillable = ['cabang', 'statusenabled', 'objectwilayahfk'];
}
