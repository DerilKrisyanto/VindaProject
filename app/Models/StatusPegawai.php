<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    protected $table = 'statuspegawai_m';
    protected $fillable = ['statuspegawai', 'statusenabled'];
}
