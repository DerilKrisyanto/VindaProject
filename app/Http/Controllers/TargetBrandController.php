<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBrand;
use App\Models\Pegawai;
use App\Models\TargetBrand;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TargetBrandExport;

class TargetBrandController extends Controller {

    public function export(Request $request) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        return Excel::download(new TargetBrandExport($bulan, $tahun), 'Big Event All Promotor.xlsx');
    }
    
    public function getFormInputTargetBrand(){
        $title = 'Target Brand';
        $brands = MasterBrand::all();
        $pegawais = Pegawai::all();
        $targetbrand = new TargetBrand();

        if (request()->has('brand_id')) {
            $pegawais = Pegawai::where('userbrand', request('brand_id'))->get();
        }

        return view('Form.FormTargetBrand', compact('brands', 'pegawais', 'title','targetbrand'));
    }

    public function SaveTargetBrand(Request $request){
        $validated = $request->validate([
            'nama_event' => 'required',
            'tanggal' => 'required|date',
            'local_partner' => 'nullable',
            'nama_media' => 'nullable',
            'link_media' => 'nullable|url',
            'jumlah_partisipan' => 'nullable|integer',
            'nama_toko' => 'nullable',
            'bentuk_kolaborasi' => 'nullable',
            'detail_kolaborasi' => 'nullable',
            'qty_keluar' => 'nullable|integer',
            'hasil_kolaborasi' => 'nullable|integer',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand_id' => 'required|exists:masterbrand_m,id',
            'pic_id' => 'required|exists:pegawai_m,id',
        ]);

        // Menyimpan file dokumentasi ke folder public/dokumentasi_target
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumentasi_target'), $fileName);
            $validated['dokumentasi'] = $fileName; 
        }

        TargetBrand::create($validated);

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function getPegawaisByBrand($brandId){
        $pegawais = Pegawai::where('userbrand', $brandId)->get();
        return response()->json($pegawais);
    }

    public function getDaftarTargetBrand(Request $request) {
        $title = 'BIG EVENT PROMOTOR';
        $data = DB::table('targetbrand_t as tb')
            ->join('masterbrand_m as mb', 'tb.brand_id', '=', 'mb.id')
            ->join('pegawai_m as pg', 'tb.pic_id', '=', 'pg.id')
            ->select('tb.*', 'mb.namabrand', 'pg.namalengkap as pic_nama')
            ->where('tb.statusenabled',true);

        if ($request->filled('bulan')) {
            $data->whereMonth('tb.tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $data->whereYear('tb.tanggal', $request->tahun);
        }

        $targetbrands = $data->orderBy('pg.id')->paginate(10)->appends($request->query());

        return view('components.targetbrand', compact('targetbrands','title'));
    }

    public function edit($id){
        $targetbrand = TargetBrand::findOrFail($id);
        $brands = MasterBrand::all();
        $pegawais = Pegawai::all();

        return view('Form.FormTargetBrand', compact('targetbrand', 'brands', 'pegawais'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nama_event' => 'required',
            'tanggal' => 'required|date',
            'local_partner' => 'nullable',
            'nama_media' => 'nullable',
            'link_media' => 'nullable|url',
            'jumlah_partisipan' => 'nullable|integer',
            'nama_toko' => 'nullable',
            'bentuk_kolaborasi' => 'nullable',
            'detail_kolaborasi' => 'nullable',
            'qty_keluar' => 'nullable|integer',
            'hasil_kolaborasi' => 'nullable|integer',
            'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'brand_id' => 'required|exists:masterbrand_m,id',
            'pic_id' => 'required|exists:pegawai_m,id',
        ]);

        $targetbrand = TargetBrand::findOrFail($id);

        // handle dokumentasi
        if ($request->hasFile('dokumentasi')) {
            if ($targetbrand->dokumentasi && file_exists(public_path('dokumentasi_target/' . $targetbrand->dokumentasi))) {
                unlink(public_path('dokumentasi_target/' . $targetbrand->dokumentasi));
            }
            $file = $request->file('dokumentasi');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('dokumentasi_target'), $fileName);
            $targetbrand->dokumentasi = $fileName;
        }

        $targetbrand->update($request->except(['_token', '_method', 'dokumentasi']));
        
        return redirect()->route('getDaftarTargetBrand')->with('success', 'Data berhasil diperbarui');
    }


    public function hapus($id) {
        $targetbrand = TargetBrand::findOrFail($id);
        $targetbrand->update(['statusenabled' => false]);

        return redirect()->route('getDaftarTargetBrand')->with('success', 'Data berhasil dinonaktifkan');
    }

}
