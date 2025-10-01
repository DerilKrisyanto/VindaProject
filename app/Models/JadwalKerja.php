<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    use HasFactory;

    protected $table = 'jadwalkerja_m';

    protected $fillable = [
        'statusenabled',
        'objectpegawaifk',
        'objecttokofk',
        'objectwilayahfk',
        'objectcabangfk',
        'objecteventfk',
        'objectstatusfk',
        'objectshiftfk',
        'jenis',
        'tahun',
        'bulan',
        'tanggal',
    ];

    // Relasi opsional
    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class, 'objectpegawaifk');
    }

    public function toko()
    {
        return $this->belongsTo(\App\Models\MasterToko::class, 'objecttokofk');
    }

    public function wilayah()
    {
        return $this->belongsTo(\App\Models\Wilayah::class, 'objectwilayahfk');
    }

    public function cabang()
    {
        return $this->belongsTo(\App\Models\Cabang::class, 'objectcabangfk');
    }

    public function event()
    {
        return $this->belongsTo(\App\Models\MasterBrand::class, 'objecteventfk');
    }

    public function statusPegawai()
    {
        return $this->belongsTo(\App\Models\StatusPegawai::class, 'objectstatusfk');
    }

    public function shift()
    {
        return $this->belongsTo(\App\Models\ShiftPegawai::class, 'objectshiftfk');
    }
}
