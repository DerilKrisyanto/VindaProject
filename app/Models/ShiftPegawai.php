<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftPegawai extends Model
{
    protected $table = 'shift_m';
    protected $fillable = ['shift', 'statusenabled'];
}
