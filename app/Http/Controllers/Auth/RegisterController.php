<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterBrand;
use App\Models\JenisPegawai;
use App\Models\StatusPegawai;
use App\Models\MasterToko;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller {
    public function TambahUserBaru(Request $request)
    {
        $rules = [
            'namalengkap' => 'required|string|max:255',
            'userbrand' => 'required|exists:masterbrand_m,id',
            'jenispegawai_id' => 'required|exists:jenispegawai_m,id',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'username' => 'required|string|unique:pegawai_m,username',
            'password' => 'required|string|confirmed',
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        // jika bukan Leader (id != 1)
        if ($request->jenispegawai_id != 1) {
            $rules['objectstatuspegawaifk'] = 'required|exists:statuspegawai_m,id';
            $rules['toko_id'] = 'required|array';
            $rules['toko_id.*'] = 'exists:mastertoko_m,id';
        } else {
            // jika Leader → boleh null
            $rules['objectstatuspegawaifk'] = 'nullable';
            $rules['toko_id'] = 'nullable';
        }

        $validated = $request->validate($rules, [
            'username.unique' => 'Username sudah ada!',
            'username.required' => 'Username wajib diisi!',
        ]);

        // hash password
        $validated['password'] = Hash::make($validated['password']);

        // encode toko jika ada
        if (isset($validated['toko_id'])) {
            $validated['toko_id'] = json_encode($validated['toko_id']);
        }

        // upload foto jika ada
        if ($request->hasFile('foto_pegawai')) {
            $file = $request->file('foto_pegawai');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Pegawai/Profile'), $fileName);
            $validated['foto_pegawai'] = $fileName;
        }

        Pegawai::create($validated);

        return redirect()->route('Login.form')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function showRegisterForm() {
        // Mengambil data brand yang aktif
        $brands = MasterBrand::where('statusenabled', true)->get();
        $jenispegawai = JenisPegawai::where('statusenabled', true)->get();
        $statuspegawai = StatusPegawai::where('statusenabled', true)->get();
        $namatoko = MasterToko::where('statusenabled', true)->get();
        // Mengirimkan data ke view
        return view('auth.Register', compact('brands','jenispegawai', 'statuspegawai', 'namatoko'));
    }

    //====== EDIT PROFILE ======//
    public function editProfile() {
        $user = Auth::user(); // Ambil data user login
        if (!$user) {
            return redirect()->route('Login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        $brands = MasterBrand::where('statusenabled', true)->get();
        $jenispegawai = JenisPegawai::where('statusenabled', true)->get();
        $statuspegawai = StatusPegawai::where('statusenabled', true)->get();
        $namatoko = MasterToko::where('statusenabled', true)->get();

        return view('auth.EditProfile', compact('user', 'brands', 'jenispegawai', 'namatoko'));
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('Login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'namalengkap' => 'nullable|string|max:255',
            'userbrand' => 'nullable|exists:masterbrand_m,id',
            'jenispegawai_id' => 'nullable|exists:jenispegawai_m,id',
            'objectstatuspegawaifk' => 'required|exists:statuspegawai_m,id',
            'toko_id' => 'required|array',
            'toko_id.*' => 'exists:mastertoko_m,id',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'foto_pegawai' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto_pegawai')) {
            $file = $request->file('foto_pegawai');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Pegawai/Profile'), $fileName);
            $validated['foto_pegawai'] = $fileName;
        }

        $validated['toko_id'] = json_encode($validated['toko_id']);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    //======= SETTING USERNAME & PASSWORD =======

    public function showSettingsForm() {
        $user = Auth::user();
        return view('auth.SettingProfile', compact('user'));
    }

    public function updateUsernamePassword(Request $request) {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|unique:pegawai_m,username,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'username.unique' => 'Username sudah digunakan!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
        ]);

        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('settings.form')->with('success', 'Data berhasil diperbarui.');
    }


}
