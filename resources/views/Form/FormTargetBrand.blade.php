<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="max-w-5xl mx-auto p-10 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">BIG EVENT PROMOTOR</h2>

        @if(session('success'))
            <div class="bg-green-200 p-3 rounded mb-4 text-green-800">{{ session('success') }}</div>
        @endif

        @php
            $isEdit = isset($targetbrand) && $targetbrand->exists;
        @endphp

        <form action="{{ $isEdit ? route('targetbrand.update', $targetbrand->id) : route('SaveTargetBrand') }}"
            method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Nama Event -->
            <div>
                <label class="block mb-1 font-medium">Nama Event</label>
                <input type="text" name="nama_event" required
                    value="{{ old('nama_event', $targetbrand->nama_event ?? '') }}"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Grid Dua Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Tanggal</label>
                        <input type="datetime-local" name="tanggal" required
                            value="{{ old('tanggal', $targetbrand->tanggal ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Local Partner</label>
                        <input type="text" name="local_partner" required
                            value="{{ old('local_partner', $targetbrand->local_partner ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Nama Media</label>
                        <input type="text" name="nama_media" required
                            value="{{ old('nama_media', $targetbrand->nama_media ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Link Media</label>
                        <input type="url" name="link_media" required
                            value="{{ old('link_media', $targetbrand->link_media ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Jumlah Partisipan</label>
                        <input type="number" name="jumlah_partisipan" placeholder="Contoh: 30" required
                            value="{{ old('jumlah_partisipan', $targetbrand->jumlah_partisipan ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Nama Toko</label>
                        <input type="text" name="nama_toko" required
                            value="{{ old('nama_toko', $targetbrand->nama_toko ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Bentuk Kolaborasi</label>
                        <input type="text" name="bentuk_kolaborasi" required
                            value="{{ old('bentuk_kolaborasi', $targetbrand->bentuk_kolaborasi ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Detail Kolaborasi</label>
                        <input type="text" name="detail_kolaborasi" required
                            value="{{ old('detail_kolaborasi', $targetbrand->detail_kolaborasi ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Qty yang Keluar dari Toko</label>
                        <input type="number" name="qty_keluar" required
                            value="{{ old('qty_keluar', $targetbrand->qty_keluar ?? '') }}"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Hasil Kolaborasi Toko</label>
                        <input type="text" id="hasil_kolaborasi_display" required
                            value="{{ old('hasil_kolaborasi_display', isset($targetbrand->hasil_kolaborasi) ? number_format($targetbrand->hasil_kolaborasi, 0, ',', '.') : '') }}"
                            class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            oninput="formatNumberDisplay(this)">
                        <input type="hidden" name="hasil_kolaborasi" id="hasil_kolaborasi"
                            value="{{ old('hasil_kolaborasi', $targetbrand->hasil_kolaborasi ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Dokumentasi -->
                <div>
                    <label class="block mb-1 font-medium">Dokumentasi</label>
                    <div class="relative">
                        <input type="file" name="dokumentasi"
                            value="{{ old('dokumentasi', $targetbrand->dokumentasi ?? '') }}"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 h-[42px] file:h-full file:py-2 file:px-4 file:border-0 file:bg-blue-100 file:text-blue-700 file:rounded-lg" />
                        @if (isset($targetbrand) && $targetbrand->dokumentasi)
                            <img src="{{ asset('dokumentasi_target/' . $targetbrand->dokumentasi) }}" alt="Dokumentasi" class="mt-2 h-20">
                        @endif

                    </div>
                </div>

                <!-- Nama Brand -->
                <div>
                    <label class="block mb-1 font-medium">Nama Brand</label>
                    <select name="brand_id" id="brand_id" required
                        class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                        <option value="">-- Pilih Brand --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ (old('brand_id', $targetbrand->brand_id) == $brand->id) ? 'selected' : '' }}>
                                {{ $brand->namabrand }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama PIC -->
                <div>
                    <label class="block mb-1 font-medium">Nama PIC</label>
                    <select name="pic_id" id="pic_id" required
                        class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                        <option value="">-- Pilih PIC --</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ (old('pic_id', $targetbrand->pic_id) == $pegawai->id) ? 'selected' : '' }}>
                                {{ $pegawai->namalengkap }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <!-- Simpan & Kembali -->
            <div class="flex gap-4 mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition w-32 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v3M9 21v-6h6v6" />
                    </svg>
                    Simpan
                </button>

                <a href="{{ route('getDaftarTargetBrand') }}"
                    class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition w-32 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>

            </div>

        </form>
        <script>
            // Tetap fungsimu yang lama
            function formatNumberDisplay(input) {
                let value = input.value.replace(/[^\d]/g, '');
                let formatted = new Intl.NumberFormat('id-ID').format(value);

                input.value = formatted;
                document.getElementById('hasil_kolaborasi').value = value;
            }

            // Fungsi AJAX filter pegawai
            document.getElementById('brand_id').addEventListener('change', function () {
                let brandId = this.value;

                fetch(`/get-pegawais-by-brand/${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        let picSelect = document.getElementById('pic_id');
                        picSelect.innerHTML = '<option value="">-- Pilih PIC --</option>';

                        data.forEach(pegawai => {
                            let option = document.createElement('option');
                            option.value = pegawai.id;
                            option.text = pegawai.namalengkap;
                            picSelect.appendChild(option);
                        });
                    });
            });
        </script>

    </div>
</x-layout>