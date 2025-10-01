<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DaftarTargetPromotor;
use App\Models\Pegawai;
use App\Models\MasterBrand;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DaftarTargetPromotorController extends Controller
{
    public function getTargetMasterPromotor() {
        $targets = DaftarTargetPromotor::where('statusenabled', true)->get();
        return view('components.daftartargetpromotor', compact('targets'));
    }

    public function SaveDaftarTargetPromotor(Request $request) {
        $request->validate([
            'nama_target' => 'required|string|unique:master_daftartargetpromotor_m,nama_target',
        ]);

        DaftarTargetPromotor::create([
            'nama_target' => $request->nama_target,
        ]);

        return back()->with('success', 'Nama Target Promotor berhasil ditambahkan');
    }

    public function HapusDaftarTargetPromotor($id) {
        $target = DaftarTargetPromotor::findOrFail($id);
        $target->statusenabled = false;
        $target->save();

        return back()->with('success', 'Target Promotor berhasil dinonaktifkan');
    }
}
