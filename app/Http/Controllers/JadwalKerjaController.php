<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\JadwalKerja;
use App\Models\Pegawai;
use App\Models\MasterToko;
use App\Models\Wilayah;
use App\Models\Cabang;
use App\Models\MasterBrand;
use App\Models\StatusPegawai;
use App\Models\ShiftPegawai;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JadwalKerjaController extends Controller
{
    public function getJadwalKerja(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('n'));

        // Ambil daftar tanggal dalam bulan (1–31)
        $tanggalList = range(1, 31);

        // Ambil Nama TL global
        $namaTLGlobal = DB::table('pegawai_m')
            ->where('jenispegawai_id', 1)
            ->value('namalengkap');

        // Ambil data utama jadwal
        $data = DB::table('jadwalkerja_m as jw')
            ->leftJoin('wilayah_m as w', 'w.id', '=', 'jw.objectwilayahfk')
            ->leftJoin('cabang_m as c', 'c.id', '=', 'jw.objectcabangfk')
            ->leftJoin('pegawai_m as p', 'p.id', '=', 'jw.objectpegawaifk')
            ->leftJoin('masterbrand_m as b', 'b.id', '=', 'jw.objecteventfk')
            ->leftJoin('mastertoko_m as t', 't.id', '=', 'jw.objecttokofk')
            ->leftJoin('statuspegawai_m as s', 's.id', '=', 'jw.objectstatusfk')
            ->leftJoin('shift_m as sh', 'sh.id', '=', 'jw.objectshiftfk')
            ->select(
                'jw.id',
                'jw.objectcabangfk',
                'w.wilayah',
                'c.cabang',
                'p.namalengkap as nama_spg',
                'b.namabrand as event',
                'jw.jenis',
                't.namatoko',
                's.statuspegawai as status',
                'jw.tahun',
                'jw.bulan',
                'jw.tanggal',  // kolom tanggal
                'sh.shift as nama_shift'
            )
            ->where('jw.tahun', $tahun)
            ->where('jw.bulan', $bulan)
            ->orderBy('w.wilayah')
            ->orderBy('c.cabang')
            ->orderBy('p.namalengkap')
            ->get();

        // Bentuk hasil akhir tabel
        $result = [];
        $temp = []; // penampung sementara per SPG-toko-bulan

        foreach ($data as $row) {
            // Buat key unik per kombinasi SPG + toko + bulan + tahun
            $key = $row->nama_spg . '|' . $row->namatoko . '|' . $row->bulan . '|' . $row->tahun;

            // Kalau belum ada di temp, inisialisasi dulu
            if (!isset($temp[$key])) {
                $jadwalHarian = [];
                foreach ($tanggalList as $tgl) {
                    $jadwalHarian[$tgl] = '-';
                }

                $temp[$key] = [
                    'wilayah' => $row->wilayah,
                    'cabang' => $row->cabang,
                    'nama_tl' => $namaTLGlobal ?? '-',
                    'nama_spg' => $row->nama_spg,
                    'event' => $row->event,
                    'jenis' => $row->jenis,
                    'nama_toko' => $row->namatoko,
                    'status' => $row->status,
                    'tahun' => $row->tahun,
                    'bulan' => $row->bulan,
                    'jadwal' => $jadwalHarian
                ];
            }

            // Tambahkan shift ke tanggal yang sesuai
            $hari = intval($row->tanggal);
            $temp[$key]['jadwal'][$hari] = $row->nama_shift ?? '-';
        }

        // Setelah semua baris selesai, pindahkan ke result final
        $result = array_values($temp);
        return view('JadwalKerja.index', ['data' => $result]);
    }

    public function InputJadwalKerja()
    {
        $toko = MasterToko::all();
        $wilayah = Wilayah::where('statusenabled', true)->get();
        $cabang = Cabang::where('statusenabled', true)->get();
        $spg = Pegawai::where('jenispegawai_id', '2')->where('statusenabled', true)->get();
        $status = StatusPegawai::where('statusenabled', true)->get();
        $event = MasterBrand::all();
        $shift = ShiftPegawai::all();
        $jadwal = JadwalKerja::with(['pegawai', 'toko', 'wilayah', 'cabang', 'event', 'statusPegawai'])->get();

        return view('Form.InputJadwalKerja', compact('spg', 'toko', 'wilayah', 'cabang', 'event', 'shift', 'status', 'jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'objectpegawaifk' => 'required',
            'objecttokofk' => 'required',
            'objectwilayahfk' => 'required',
            'objectcabangfk' => 'required',
            'objecteventfk' => 'required',
            'objectstatusfk' => 'required',
            'objectshiftfk' => 'required',
            'jenis' => 'required',
            'tanggal' => 'required|date',
        ]);

        // Ambil tanggal, bulan, tahun dari input
        $tanggal = date('d', strtotime($request->tanggal));
        $bulan = date('m', strtotime($request->tanggal));
        $tahun = date('Y', strtotime($request->tanggal));

        // 🔍 Cek apakah kombinasi SPG + Toko + Tanggal sudah ada
        $cekJadwal = JadwalKerja::where('objectpegawaifk', $request->objectpegawaifk)
            ->where('objecttokofk', $request->objecttokofk)
            ->where('tanggal', $tanggal)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if ($cekJadwal) {
            // Format tanggal untuk tampilan alert
            $tanggalLengkap = \Carbon\Carbon::createFromDate($tahun, $bulan, $tanggal)
                ->locale('id')
                ->translatedFormat('l, d F Y');

            return redirect()->back()
                ->with('error', "SPG ini sudah memiliki jadwal pada {$tanggalLengkap}.");
        }

        // ✅ Jika belum ada, simpan data baru
        $jadwal = JadwalKerja::updateOrCreate(
            [
                'objectpegawaifk' => $request->objectpegawaifk,
                'objecttokofk' => $request->objecttokofk,
                'tanggal' => $tanggal,
                'bulan' => $bulan,
                'tahun' => $tahun
            ],
            [
                'objectwilayahfk' => $request->objectwilayahfk,
                'objectcabangfk' => $request->objectcabangfk,
                'objecteventfk' => $request->objecteventfk,
                'objectstatusfk' => $request->objectstatusfk,
                'objectshiftfk' => $request->objectshiftfk,
                'jenis' => $request->jenis,
            ]
        );

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan!');
    }

    public function getTokoDetail($id)
    {
        $toko = MasterToko::select('id', 'objectwilayahfk', 'objectcabangfk')
            ->with([
                'wilayah:id,wilayah',
                'cabang:id,cabang'
            ])
            ->find($id);

        if (!$toko) {
            return response()->json(['message' => 'Toko tidak ditemukan'], 404);
        }

        return response()->json([
            'wilayah_id' => $toko->objectwilayahfk,
            'wilayah_nama' => $toko->wilayah->wilayah ?? '',
            'cabang_id' => $toko->objectcabangfk,
            'cabang_nama' => $toko->cabang->cabang ?? ''
        ]);
    }


    public function destroy($id)
    {
        JadwalKerja::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }

    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('n'));

        $tanggalList = range(1, 31);

        $namaTLGlobal = DB::table('pegawai_m')
            ->where('jenispegawai_id', 1)
            ->value('namalengkap');

        $data = DB::table('jadwalkerja_m as jw')
            ->leftJoin('wilayah_m as w', 'w.id', '=', 'jw.objectwilayahfk')
            ->leftJoin('cabang_m as c', 'c.id', '=', 'jw.objectcabangfk')
            ->leftJoin('pegawai_m as p', 'p.id', '=', 'jw.objectpegawaifk')
            ->leftJoin('masterbrand_m as b', 'b.id', '=', 'jw.objecteventfk')
            ->leftJoin('mastertoko_m as t', 't.id', '=', 'jw.objecttokofk')
            ->leftJoin('statuspegawai_m as s', 's.id', '=', 'jw.objectstatusfk')
            ->leftJoin('shift_m as sh', 'sh.id', '=', 'jw.objectshiftfk')
            ->select(
                'jw.id',
                'w.wilayah',
                'c.cabang',
                'p.namalengkap as nama_spg',
                'b.namabrand as event',
                'jw.jenis',
                't.namatoko',
                's.statuspegawai as status',
                'jw.tahun',
                'jw.bulan',
                'jw.tanggal',
                'sh.shift as nama_shift'
            )
            ->where('jw.tahun', $tahun)
            ->where('jw.bulan', $bulan)
            ->orderBy('w.wilayah')
            ->orderBy('c.cabang')
            ->orderBy('p.namalengkap')
            ->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Tidak ada data jadwal kerja untuk bulan & tahun ini.');
        }

        $temp = [];
        foreach ($data as $row) {
            $key = $row->nama_spg . '|' . $row->namatoko . '|' . $row->bulan . '|' . $row->tahun;

            if (!isset($temp[$key])) {
                $jadwalHarian = [];
                foreach ($tanggalList as $tgl) {
                    $jadwalHarian[$tgl] = '-';
                }

                $temp[$key] = [
                    'wilayah' => $row->wilayah,
                    'cabang' => $row->cabang,
                    'nama_tl' => $namaTLGlobal ?? '-',
                    'nama_spg' => $row->nama_spg,
                    'event' => $row->event,
                    'jenis' => $row->jenis,
                    'nama_toko' => $row->namatoko,
                    'status' => $row->status,
                    'tahun' => $row->tahun,
                    'bulan' => $row->bulan,
                    'jadwal' => $jadwalHarian
                ];
            }

            $hari = intval($row->tanggal);
            $temp[$key]['jadwal'][$hari] = $row->nama_shift ?? '-';
        }

        $result = array_values($temp);

        // 📘 Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 🔹 Header
        $headers = [
            'Wilayah', 'Cabang', 'Nama TL', 'Nama SPG', 'Event',
            'Jenis', 'Nama Toko', 'Status', 'Tahun', 'Bulan'
        ];
        foreach ($tanggalList as $tgl) {
            $headers[] = $tgl;
        }

        // Tulis header ke baris pertama
        $col = 1;
        foreach ($headers as $header) {
            $sheet->setCellValueByColumnAndRow($col, 1, $header);
            $col++;
        }

        // 🔹 Isi data
        $rowNum = 2;
        foreach ($result as $item) {
            $colNum = 1;
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['wilayah']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['cabang']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['nama_tl']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['nama_spg']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['event']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['jenis']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['nama_toko']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['status']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['tahun']);
            $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['bulan']);

            foreach ($tanggalList as $tgl) {
                $sheet->setCellValueByColumnAndRow($colNum++, $rowNum, $item['jadwal'][$tgl]);
            }

            $rowNum++;
        }

        // 🔹 Styling sederhana
        $sheet->getStyle('A1:AI1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        // 🔹 Nama file
        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');
        $filename = "Rekap_Jadwal_{$namaBulan}_{$tahun}.xlsx";

        // Output ke browser (tanpa simpan file)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function EditJadwalKerja()
    {
        $toko = MasterToko::all();
        $wilayah = Wilayah::where('statusenabled', true)->get();
        $cabang = Cabang::where('statusenabled', true)->get();
        $spg = Pegawai::where('jenispegawai_id', 2)->where('statusenabled', true)->get();
        $status = StatusPegawai::where('statusenabled', true)->get();
        $event = MasterBrand::all();
        $shift = ShiftPegawai::all();

        return view('Form.EditJadwalKerja', compact('spg', 'toko', 'wilayah', 'cabang', 'event', 'shift', 'status'));
    }

    // AJAX: ambil SPG berdasarkan tanggal
    public function getSPGbyTanggal($tanggal)
    {
        [$tahun, $bulan, $hari] = explode('-', $tanggal);

        $spg = JadwalKerja::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('tanggal', $hari)
            ->with('pegawai')
            ->get()
            ->pluck('pegawai')
            ->unique('id')
            ->values();

        return response()->json($spg);
    }

    // AJAX: ambil Toko dan Shift berdasarkan SPG + tanggal
    public function getTokoShift(Request $request)
    {
        [$tahun, $bulan, $hari] = explode('-', $request->tanggal);

        $data = JadwalKerja::where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('tanggal', $hari)
            ->where('objectpegawaifk', $request->spg_id)
            ->with(['toko', 'shift'])
            ->get();

        return response()->json([
            'toko' => $data->pluck('toko')->unique('id')->values(),
            'shift' => $data->pluck('shift')->unique('id')->values()
        ]);
    }

    // AJAX: Update atau simpan jadwal
    public function updateJadwal(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'objectpegawaifk' => 'required|exists:pegawai,id',
            'objecttokofk' => 'required|exists:mastertoko,id',
            'objectshiftfk' => 'required|exists:shiftpegawai,id',
            'objectwilayahfk' => 'required|exists:wilayah,id',
            'objectcabangfk' => 'required|exists:cabang,id',
            'objecteventfk' => 'required|exists:masterbrand,id',
            'objectstatusfk' => 'required|exists:statuspegawai,id',
            'jenis' => 'required|string'
        ]);

        $jadwal = JadwalKerja::updateOrCreate(
            [
                'tanggal' => $validated['tanggal'],
                'pegawai_id' => $validated['objectpegawaifk'],
                'toko_id' => $validated['objecttokofk']
            ],
            [
                'shift_id' => $validated['objectshiftfk'],
                'wilayah_id' => $validated['objectwilayahfk'],
                'cabang_id' => $validated['objectcabangfk'],
                'event_id' => $validated['objecteventfk'],
                'statuspegawai_id' => $validated['objectstatusfk'],
                'jenis' => $validated['jenis']
            ]
        );

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan/update!');
    }

}
