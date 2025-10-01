<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterBrand;
use App\Models\DaftarTargetPromotor;
use App\Models\Pegawai;
use App\Models\TargetBrand;
use App\Models\TargetTimPromotor;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TargetTimPromotorExport;

class TargetTimPromotorController extends Controller
{
    // Excport data ke Excel
    public function getDownloadTargetTimPromotor(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(new TargetTimPromotorExport($bulan, $tahun), 'Target Tim Promotor.xlsx');
    }
    // Menampilkan Daftar Target Tim Promotor
    public function getDaftarTargetTimPromotor(Request $request) {
        $title = 'EVENT BIGBET';

        // Ambil semua nama_target dari master
        $targets = DB::table('daftartargetpromotor_m')
            ->where('statusenabled', true)
            ->get();

        // Query awal
        $TargetTim = TargetTimPromotor::where('statusenabled', true);

        // Tambahkan filter jika ada
        if ($request->filled('bulan')) {
            $TargetTim->whereMonth('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $TargetTim->whereYear('bulan', $request->tahun);
        }

        // Eksekusi query
        $dataRows = $TargetTim->orderBy('bulan', 'desc')->get();

        // Susun ulang data per target_id
        $dataPerTarget = [];
        foreach ($targets as $target) {
            $dataTarget = $dataRows->where('target_id', $target->id)->first();

            if ($dataTarget) {
                $dataPerTarget[$target->id] = [
                    'qty_target' => $dataTarget->qty_target ?? '-',
                    'pic_nama' => $dataTarget->pic_nama ?? '-',
                    'relasi' => $dataTarget->relasi ?? '-',
                ];
            } else {
                $dataPerTarget[$target->id] = [
                    'qty_target' => '-',
                    'pic_nama' => '-',
                    'relasi' => '-',
                ];
            }
        }

        return view('components.targettimpromotor', compact('title', 'targets', 'dataPerTarget'));
    }


    public function editTargetTimPromotor($id) {
        $title = 'Edit Target Tim Promotor';
        $data = DB::table('targettimpromotor_t')->where('id', $id)->first();

        $brands = DB::table('masterbrand_m')->where('statusenabled', true)->get();
        $targets = DB::table('daftartargetpromotor_m')->where('statusenabled', true)->get();

        return view('components.InputTargetTimPromotor', compact('title', 'data', 'brands', 'targets'));
    }

    public function updateTargetTimPromotor(Request $request, $id) {
        DB::table('targettimpromotor_t')->where('id', $id)->update([
            'bulan' => $request->bulan,
            'brand_id' => $request->brand_id,
            'target_id' => $request->target_id,
            'pic_id' => json_encode($request->pic_id),
            'last_update' => now(),
        ]);

        return redirect()->route('getDaftarTargetTimPromotor')->with('success', 'Data berhasil diperbarui.');
    }

    public function hapusTargetTimPromotor($id) {
        DB::table('targettimpromotor_t')->where('id', $id)->update([
            'statusenabled' => false,
            'last_update' => now()
        ]);

        return redirect()->route('getDaftarTargetTimPromotor')->with('success', 'Data berhasil di-nonaktifkan.');
    }

    // Menampilkan form input
    public function getInputTargetTimPromotor() {
        $title = 'Target Brand';
        $brands = MasterBrand::where('statusenabled', true)->get();
        $targets = DaftarTargetPromotor::where('statusenabled', true)->get();
        $targetbrand = new TargetBrand();
        $pegawais = Pegawai::where('statusenabled', true)->get();

        return view('Form.InputTargetTimPromotor', compact('brands', 'targets', 'pegawais', 'targetbrand', 'title'));
    }

    // Simpan data target tim
    public function SaveTargetTim(Request $request) {
        $validated = $request->validate([
            'brand_id' => 'required|exists:masterbrand_m,id',
            'target_id' => 'required|exists:daftartargetpromotor_m,id',
            'qty_target' => 'required|integer',
            'bulan' => 'required|date',
            'pic_id' => 'required|array',
            'pic_id.*' => 'exists:pegawai_m,id',
        ]);

        TargetTimPromotor::create([
            'brand_id' => $validated['brand_id'],
            'target_id' => $validated['target_id'],
            'qty_target' => $validated['qty_target'],
            'bulan' => $validated['bulan'],
            'pic_id' => json_encode($validated['pic_id']),
            'statusenabled' => true,
        ]);

        return redirect()->route('getInputTargetTimPromotor')->with('success', 'Data berhasil disimpan..');
    }

    // // Menampilkan form input target tim promotor
    // public function getFormInputTargetTimPromotor() {
    //     $title = 'Target Brand';
    //     $brands = MasterBrand::where('statusenabled', true)->get();
    //     $targets = DaftarTargetPromotor::where('statusenabled', true)->get();
    //     $data = DB::table('targettimpromotor_t as tt')
    //         ->join('masterbrand_m as mb', 'tt.brand_id', '=', 'mb.id')
    //         ->join('daftartargetpromotor_m as dtp', 'tt.target_id', '=', 'dtp.id')
    //         ->select('tt.*', 'mb.namabrand', 'dtp.nama_target')
    //         ->where('tt.statusenabled', true)
    //         ->orderBy('tt.bulan', 'desc')
    //         ->get();

    //     return view('Form.InputTargetTimPromotor', compact('data','title','brands','targets'));
    // }


    // Soft-delete (ubah statusenabled jadi false)
    public function destroy($id)
    {
        DB::table('targettimpromotor_t')
            ->where('id', $id)
            ->update(['statusenabled' => false]);

        return redirect()->route('getInputTargetTimPromotor')->with('success', 'Data berhasil dihapus');
    }
}
