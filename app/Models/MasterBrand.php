<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBrand extends Model
{
    protected $table = 'masterbrand_m';

    protected $fillable = ['namabrand', 'statusenabled'];

    public $timestamps = true;
}