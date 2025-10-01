<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterToko;
use App\Models\Wilayah;
use App\Models\Cabang;
use App\Models\ShiftPegawai;
use App\Models\Pegawai;
use App\Models\MasterBrand;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterDataController extends Controller
{
    public function getDataToko() {
        // Ambil data toko + join cabang dan wilayah
        $dataToko = \DB::table('mastertoko_m as mt')
            ->join('cabang_m as c', 'c.id', '=', 'mt.objectcabangfk')
            ->join('wilayah_m as w', 'w.id', '=', 'mt.objectwilayahfk')
            ->select(
                'mt.id',
                'mt.namatoko',
                'c.cabang',
                'w.wilayah'
            )
            ->where('mt.statusenabled', true)
            ->get();

        // Ambil master untuk dropdown (jika dibutuhkan)
        $wilayah = \DB::table('wilayah_m')->where('statusenabled', true)->get();
        $cabang = \DB::table('cabang_m')->where('statusenabled', true)->get();

        // Kirim data ke view
        return view('masterdata.DataToko', [
            'tokos' => $dataToko,
            'wilayah' => $wilayah,
            'cabang' => $cabang,
        ]);
    }


    public function SaveDataToko(Request $request) {
        $request->validate([
            'namatoko' => 'required|string|unique:mastertoko_m,namatoko',
            'objectwilayahfk' => 'required',
            'objectcabangfk' => 'required',
        ]);

        MasterToko::create([
            'namatoko' => $request->namatoko,
            'objectwilayahfk' => $request->objectwilayahfk,
            'objectcabangfk' => $request->objectcabangfk,
        ]);

        return back()->with('success', 'Data Toko berhasil ditambahkan');
    }

    public function HapusDataShift($id) {
        $tokos = MasterToko::findOrFail($id);
        $tokos->statusenabled = false;
        $tokos->save();

        return back()->with('success', 'Data Toko berhasil dinonaktifkan');
    }


    //======= Master Data Shift =======//
    public function getDataShift() {
        // Ambil data shift + join cabang dan wilayah
        $dataShift = \DB::table('shift_m')->where('statusenabled', true)->get();

        // Kirim data ke view
        return view('masterdata.DataShift', ['dataShift' => $dataShift]);
    }


    public function SaveDataShift(Request $request) {
        $request->validate([
            'shift' => 'required|string|unique:shift_m,shift',
        ]);

        ShiftPegawai::create([
            'shift' => $request->shift,
        ]);

        return back()->with('success', 'Data Shift berhasil ditambahkan');
    }

    public function HapusDataToko($id) {
        $dataShift = ShiftPegawai::findOrFail($id);
        $dataShift->statusenabled = false;
        $dataShift->save();

        return back()->with('success', 'Data Shift berhasil dinonaktifkan');
    }
}
