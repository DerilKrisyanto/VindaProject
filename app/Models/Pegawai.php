<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    protected $table = 'pegawai_m';

    protected $fillable = [
        'username', 'password', 'namalengkap', 'userbrand','foto_pegawai', 'no_telepon', 'email','jenispegawai_id', 'objectstatuspegawaifk','toko_id',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;
}