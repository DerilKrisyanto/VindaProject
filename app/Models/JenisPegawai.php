<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPegawai extends Model
{
    protected $table = 'jenispegawai_m';

    protected $fillable = ['jenispegawai', 'statusenabled'];

    public $timestamps = true;
}