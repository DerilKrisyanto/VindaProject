<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MasterBrand;
use App\Models\DaftarTargetPromotor;
use App\Models\Pegawai;
use App\Models\TargetBrand;
use App\Models\TargetTimPromotor;
use App\Models\TargetPromotor;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

class TargetPromotorController extends Controller
{
    public function getTargetPromotor(Request $request) {
        $user = auth('pegawai')->user();
        $pegawaiId = $user->id;
        $userBrand = $user->userbrand;
        
        $daftarTargets = DB::table('targettimpromotor_t as ttpt')
            ->leftJoin('targetpromotor_t as tpt', 'ttpt.id', '=', 'tpt.targettim_id')
            ->join('daftartargetpromotor_m as dtpm', 'ttpt.target_id', '=', 'dtpm.id')
            ->join('masterbrand_m as mb', 'ttpt.brand_id', '=', 'mb.id')
            ->select(
                'mb.namabrand',
                'ttpt.bulan',
                'ttpt.pic_id',
                'ttpt.qty_target',
                'tpt.nama_collab',
                'dtpm.nama_target',
                'tpt.produk',
                'tpt.platform',
                'tpt.link_konten',
                'tpt.ket_tambahan'
            )
            ->where('ttpt.statusenabled', true)
            ->where('ttpt.brand_id', $userBrand);

        if ($pegawaiId) {
            $daftarTargets->where(function ($q) use ($pegawaiId) {
                $q->whereRaw("JSON_CONTAINS(ttpt.pic_id, ?)", [json_encode([(string)$pegawaiId])])
                ->orWhereNull('ttpt.pic_id');
            });
        }
        // Filter bulan dan tahun
        if ($request->filled('bulan')) {
            $daftarTargets->whereMonth('ttpt.bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $daftarTargets->whereYear('ttpt.bulan', $request->tahun);
        }

        $dataAll = $daftarTargets->get()->map(function ($item) {
            $picIds = json_decode($item->pic_id, true);
            $item->pic_nama = DB::table('pegawai_m')
                ->whereIn('id', $picIds ?? [])
                ->pluck('namalengkap')
                ->implode(', ');
            return $item;
        });

        

        return view('components.targetpromotor', [
            'targetData' => $dataAll
        ]);
    }


    public function saveTargetPromotor() {
        $brands = MasterBrand::all();
        $pics = Pegawai::all();
        $targettims = TargetTimPromotor::all();
        return view('Form.inputtargetpromotor', compact('brands', 'pics', 'targettims'));
    }

    public function editTargetPromotor(Request $request) {
        TargetPromotor::create($request->all());
        return redirect()->route('getTargetPromotor')->with('success', 'Data berhasil disimpan');
    }

    public function hapusTargetPromotor($id) {
        $data = TargetPromotor::findOrFail($id);
        $data->statusenabled = false;
        $data->save();

        return redirect()->route('getTargetPromotor')->with('success', 'Data berhasil dinonaktifkan');
    }

    //================= FORM INPUT TARGET PROMOTOR ==================

    public function getFormInputTargetPromotor(Request $request) {
        $user = auth('pegawai')->user();
        $pegawaiId = $user->id;
        $userBrand = $user->userbrand;

        
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');


        // Ambil data tema
        $temas = DB::table('targettimpromotor_t')
            ->join('daftartargetpromotor_m', 'targettimpromotor_t.target_id', '=', 'daftartargetpromotor_m.id')
            ->where('targettimpromotor_t.statusenabled', true)
            ->where('targettimpromotor_t.brand_id', $userBrand)
            ->whereMonth('targettimpromotor_t.bulan', $bulan)
            ->whereYear('targettimpromotor_t.bulan', $tahun)
            ->whereRaw("JSON_CONTAINS(targettimpromotor_t.pic_id, ?)", [json_encode([(string)$pegawaiId])])
            ->select('daftartargetpromotor_m.id', 'daftartargetpromotor_m.nama_target')
            ->distinct()
            ->get();

        return view('Form.InputTargetPromotor', [
            'temas' => $temas,
            'selectedBulan' => $bulan,
            'selectedTahun' => $tahun
        ]);
    }


    public function saveInputTargetPromotor(Request $request) {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'target_id' => 'required',
            'nama_collab' => 'required|string',
            'produk' => 'required|string',
            'platform' => 'required|array|min:1',
            'link_konten' => 'required|string',
            'ket_tambahan' => 'nullable|string',
        ]);

        // Ambil user login
        $user = auth('pegawai')->user();
        $pegawaiId = $user->id;
        $userBrand = $user->userbrand;

        // Cari target tim yang cocok
        $targetTim = DB::table('targettimpromotor_t')
            ->where('statusenabled', true)
            ->where('brand_id', $userBrand)
            ->whereMonth('bulan', $request->bulan)
            ->whereYear('bulan', $request->tahun)
            ->where('target_id', $request->target_id)
            ->whereRaw("JSON_CONTAINS(pic_id, ?)", [json_encode([(string)$pegawaiId])])
            ->first();

        if (!$targetTim) {
            return back()->with('error', 'Target tidak ditemukan untuk bulan, tahun dan tema yang dipilih.');
        }

        // Simpan data
        TargetPromotor::create([
            'targettim_id'   => $targetTim->id,
            'brand_id'       => $userBrand,          // Tambahkan brand_id
            'pic_id'         => $pegawaiId,          // Tambahkan pic_id
            'nama_collab'    => $request->nama_collab,
            'produk'         => $request->produk,
            'platform'       => implode(', ', $request->platform),
            'link_konten'    => $request->link_konten,
            'ket_tambahan'   => $request->ket_tambahan,
        ]);

        return redirect()->route('getFormInputTargetPromotor')->with('success', 'Data berhasil disimpan.');
    }


}
