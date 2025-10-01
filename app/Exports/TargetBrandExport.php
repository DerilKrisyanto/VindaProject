<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TargetBrandExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    // Constructor untuk menangkap bulan dan tahun yang dipilih
    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // Fungsi untuk mengambil data dari database dengan filter bulan dan tahun
    public function collection()
    {
        $query = DB::table('targetbrand_t')
            ->join('masterbrand_m', 'targetbrand_t.brand_id', '=', 'masterbrand_m.id')
            ->join('pegawai_m', 'targetbrand_t.pic_id', '=', 'pegawai_m.id')
            ->select(
                'masterbrand_m.namabrand',
                'targetbrand_t.nama_event',
                'targetbrand_t.tanggal',
                'targetbrand_t.local_partner',
                'targetbrand_t.nama_media',
                'targetbrand_t.link_media',
                'targetbrand_t.nama_toko',
                'targetbrand_t.bentuk_kolaborasi',
                'targetbrand_t.detail_kolaborasi',
                'targetbrand_t.qty_keluar',
                'targetbrand_t.hasil_kolaborasi',
                'pegawai_m.namalengkap as pic_nama'
            );

        // Filter berdasarkan bulan
        if ($this->bulan) {
            $query->whereMonth('targetbrand_t.tanggal', $this->bulan);
        }

        // Filter berdasarkan tahun
        if ($this->tahun) {
            $query->whereYear('targetbrand_t.tanggal', $this->tahun);
        }

        return $query->get();
    }

    // Menentukan header untuk file Excel
    public function headings(): array
    {
        return [
            'Brand',
            'Nama Event',
            'Tanggal',
            'Local Partner',
            'Nama Media',
            'Link Media',
            'Nama Toko',
            'Bentuk Kolaborasi',
            'Detail Kolaborasi',
            'Qty Keluar',
            'Hasil Kolaborasi',
            'Promotor',
        ];
    }
}

