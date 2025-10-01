<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\TargetTimPromotor;
use App\Models\Pegawai;

class TargetTimPromotorExport implements FromArray, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun) {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function array(): array {
        $targets = DB::table('daftartargetpromotor_m')
            ->where('statusenabled', true)
            ->get();

        $TargetTim = TargetTimPromotor::where('statusenabled', true);

        if ($this->bulan) {
            $TargetTim->whereMonth('bulan', $this->bulan);
        }

        if ($this->tahun) {
            $TargetTim->whereYear('bulan', $this->tahun);
        }

        $dataRows = $TargetTim->orderBy('bulan', 'desc')->get();

        $qtyRow = ['Qty Target'];
        $picRow = ['PIC'];

        foreach ($targets as $target) {
            $dataTarget = $dataRows->where('target_id', $target->id)->first();

            // Qty Target
            $qtyRow[] = $dataTarget->qty_target ?? '-';

            // Nama PIC
            $picNama = '-';
            if ($dataTarget && !empty($dataTarget->pic_id)) {
                $picIds = json_decode($dataTarget->pic_id, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($picIds)) {
                    // Convert ke integer dan ambil nama
                    $picIds = array_map('intval', $picIds);

                    $namaList = DB::table('pegawai_m')
                        ->whereIn('id', $picIds)
                        ->pluck('namalengkap')
                        ->toArray();

                    if (!empty($namaList)) {
                        $picNama = implode(', ', array_map('trim', $namaList));
                    }
                }
            }

            $picRow[] = $picNama;
        }

        return [
            $qtyRow,
            $picRow,
        ];
    }


    public function headings(): array {
        $targets = DB::table('daftartargetpromotor_m')
            ->where('statusenabled', true)
            ->pluck('nama_target')
            ->toArray();

        return array_merge(['#'], $targets);
    }
}