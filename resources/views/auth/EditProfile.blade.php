<x-layout>
    <x-slot:title>Edit Profile</x-slot:title>

    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">
        <h2 class="text-xl font-bold text-center mb-6">Data Pegawai</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 font-semibold mt-4">Nama Lengkap</label>
                <input type="text" name="namalengkap" value="{{ old('namalengkap', $user->namalengkap) }}"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-2 font-semibold mt-4">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-2 font-semibold mt-4">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block mb-2 font-semibold mt-4">Brand</label>
                <select name="userbrand"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                    <option value="">- Pilih Brand -</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $user->userbrand == $brand->id ? 'selected' : '' }}>
                            {{ $brand->namabrand }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold mt-4">Jenis Pegawai</label>
                <select name="jenispegawai_id"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                    <option value="">- Pilih Jenis Pegawai -</option>
                    @foreach ($jenispegawai as $jenis)
                        <option value="{{ $jenis->id }}" {{ $user->jenispegawai_id == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->jenispegawai }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 font-semibold mt-4">Foto Profil</label>
                <input type="file" name="foto_pegawai"
                    class="block w-full border rounded-lg text-sm text-gray-900 file:bg-blue-100 file:text-blue-700 file:rounded-lg file:px-4 file:py-2 file:border-0">
                
                @if ($user->foto_pegawai)
                    <p class="mt-2 text-sm text-gray-600">Foto saat ini:</p>
                    <div class="mt-2 flex justify-center">
                        <img src="{{ asset('Pegawai/Profile/'.$user->foto_pegawai) }}" class="h-24 rounded-lg shadow" alt="Foto Profil">
                    </div>
                @endif
            </div>


            <!-- Tombol -->
            <div class="flex gap-4 mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition w-32 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v3M9 21v-6h6v6" />
                    </svg>
                    Simpan
                </button>

                <a href="{{ route('home') }}"
                    class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition w-32 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-layout>
