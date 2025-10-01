<x-layout>
    <x-slot:title>Edit Jadwal Kerja</x-slot:title>

    <div class="max-w-5xl mx-auto p-10 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Edit Jadwal Kerja</h2>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form Input --}}
        <form action="{{ route('jadwalkerja.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Filter Periode --}}
            <div>
                <label class="block mb-1 font-semibold">Tanggal</label>
                <input 
                    type="date" 
                    id="tanggal" 
                    name="tanggal" 
                    required 
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]"
                    onchange="tampilkanTanggal()"
                >

                <!-- Hasil Format -->
                <div id="hasilTanggal" 
                    class="mt-2 text-sm font-semibold text-blue-700 bg-blue-50 p-2 rounded hidden">
                </div>
            </div>
            {{-- SPG --}}
            <div>
                <label class="block mb-1 font-semibold">Nama SPG</label>
                <select name="objectpegawaifk" class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" required>
                    <option value="">-- Pilih SPG --</option>
                    @foreach($spg as $item)
                        <option value="{{ $item->id }}">{{ $item->namalengkap }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Toko --}}
            <div>
                <label class="block mb-1 font-semibold">Nama Toko</label>
                <select name="objecttokofk" id="objecttokofk"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" required>
                    <option value="">-- Pilih Toko --</option>
                    @foreach($toko as $item)
                        <option value="{{ $item->id }}">{{ $item->namatoko }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Shift Kerja --}}
            <div>
                <label class="block mb-1 font-semibold">Shift Kerja</label>
                <select name="objectshiftfk" id="objectshiftfk"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" required>
                    <option value="">-- Pilih Shift --</option>
                    @foreach($shift as $item)
                        <option value="{{ $item->id }}">{{ $item->shift }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Wilayah --}}
            <div>
                <label class="block mb-1 font-semibold">Wilayah</label>
                <select name="objectwilayahfk" id="objectwilayahfk"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" required>
                    <option value="">-- Pilih Wilayah --</option>
                    @foreach($wilayah as $item)
                        <option value="{{ $item->id }}">{{ $item->wilayah }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Cabang --}}
            <div>
                <label class="block mb-1 font-semibold">Cabang</label>
                <select name="objectcabangfk" id="objectcabangfk"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabang as $item)
                        <option value="{{ $item->id }}">{{ $item->cabang }}</option>
                    @endforeach
                </select>
            </div>

            <script>
                function tampilkanTanggal() {
                    const inputTanggal = document.getElementById('tanggal').value;
                    const hasilTanggal = document.getElementById('hasilTanggal');

                    if (inputTanggal) {
                        const tanggalObj = new Date(inputTanggal);

                        // Daftar nama hari & bulan dalam bahasa Indonesia
                        const hari = [
                            'Minggu', 'Senin', 'Selasa', 'Rabu', 
                            'Kamis', 'Jumat', 'Sabtu'
                        ];

                        const bulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];

                        const namaHari = hari[tanggalObj.getDay()];
                        const tanggal = String(tanggalObj.getDate()).padStart(2, '0');
                        const namaBulan = bulan[tanggalObj.getMonth()];
                        const tahun = tanggalObj.getFullYear();

                        // Format akhir
                        const formatLengkap = `${namaHari}, ${tanggal} - ${namaBulan} - ${tahun}`;

                        hasilTanggal.textContent = formatLengkap;
                        hasilTanggal.classList.remove('hidden');
                    } else {
                        hasilTanggal.classList.add('hidden');
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    const tokoSelect = document.getElementById('objecttokofk');
                    const wilayahSelect = document.getElementById('objectwilayahfk');
                    const cabangSelect = document.getElementById('objectcabangfk');

                    tokoSelect.addEventListener('change', function () {
                        const tokoId = this.value;
                        if (!tokoId) {
                            wilayahSelect.value = '';
                            cabangSelect.value = '';
                            return;
                        }

                        fetch(`/get-toko-detail/${tokoId}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.wilayah_id) {
                                    wilayahSelect.value = data.wilayah_id;
                                }
                                if (data.cabang_id) {
                                    cabangSelect.value = data.cabang_id;
                                }
                            })
                            .catch(err => console.error('Error:', err));
                    });
                });

                document.querySelector('form').addEventListener('submit', function() {
                    this.querySelector('button[type="submit"]').disabled = true;
                });

            </script>


            {{-- Event --}}
            <div>
                <label class="block mb-1 font-semibold">Event / Brand</label>
                <select 
                    name="objecteventfk" 
                    id="eventSelect"
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" 
                    required>
                    @foreach($event as $key => $item)
                        <option value="{{ $item->id }}" {{ $key == 0 ? 'selected' : '' }}>
                            {{ $item->namabrand }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                {{-- Jenis --}}
                <div class="w-full md:w-1/2">
                    <label class="block mb-1 font-semibold">Jenis</label>
                    <select 
                        name="jenis" 
                        id="jenisSelect"
                        class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" 
                        required>
                        <option value="LKA" selected>LKA</option>
                        <option value="GT">GT</option>
                    </select>
                </div>

                {{-- Status --}}
                <div class="w-full md:w-1/2">
                    <label class="block mb-1 font-semibold">Status</label>
                    <select 
                        name="objectstatusfk" 
                        id="statusSelect"
                        class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]" 
                        required>
                        @foreach($status as $key => $item)
                            <option value="{{ $item->id }}" {{ $key == 0 ? 'selected' : '' }}>
                                {{ $item->statuspegawai }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 🔹 Tombol Aksi --}}
            <div class="flex gap-2 mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white text-xs sm:text-sm px-3 py-1.5 rounded hover:bg-blue-700 transition w-28 text-center flex items-center justify-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v3M9 21v-6h6v6" />
                    </svg>
                    Simpan
                </button>

                <a href="{{ url('/get-jadwal-kerja') }}"
                    class="bg-orange-600 text-white text-xs sm:text-sm px-3 py-1.5 rounded hover:bg-orange-700 transition w-28 text-center flex items-center justify-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const tanggalInput = document.getElementById('tanggal');
            const spgSelect = document.querySelector('select[name="objectpegawaifk"]');
            const tokoSelect = document.getElementById('objecttokofk');
            const shiftSelect = document.getElementById('objectshiftfk');

            // Ketika tanggal dipilih
            tanggalInput.addEventListener('change', function () {
                const tanggal = this.value;

                if (!tanggal) return;

                // Update format tanggal
                tampilkanTanggal();

                // Ambil SPG berdasarkan tanggal
                fetch(`/get-spg-by-tanggal/${tanggal}`)
                    .then(res => res.json())
                    .then(data => {
                        spgSelect.innerHTML = '<option value="">-- Pilih SPG --</option>';
                        data.forEach(spg => {
                            spgSelect.innerHTML += `<option value="${spg.id}">${spg.namalengkap}</option>`;
                        });
                        tokoSelect.innerHTML = '<option value="">-- Pilih Toko --</option>';
                        shiftSelect.innerHTML = '<option value="">-- Pilih Shift --</option>';
                    })
                    .catch(err => console.error(err));
            });

            // Ketika SPG dipilih
            spgSelect.addEventListener('change', function () {
                const spgId = this.value;
                const tanggal = tanggalInput.value;
                if (!spgId || !tanggal) return;

                fetch('/get-toko-shift', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ spg_id: spgId, tanggal: tanggal })
                })
                .then(res => res.json())
                .then(data => {
                    // Update Toko
                    tokoSelect.innerHTML = '<option value="">-- Pilih Toko --</option>';
                    data.toko.forEach(t => {
                        tokoSelect.innerHTML += `<option value="${t.id}">${t.namatoko}</option>`;
                    });

                    // Update Shift
                    shiftSelect.innerHTML = '<option value="">-- Pilih Shift --</option>';
                    data.shift.forEach(s => {
                        shiftSelect.innerHTML += `<option value="${s.id}">${s.shift}</option>`;
                    });
                })
                .catch(err => console.error(err));
            });

        });
    </script>

</x-layout>
