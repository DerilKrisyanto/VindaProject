<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah_m';
    protected $fillable = ['wilayah', 'statusenabled'];
}
