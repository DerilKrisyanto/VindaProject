<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Input Target Tim Promotor</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('SaveTargetTim') }}" method="POST">
            @csrf

            <!-- Pilih Nama Brand -->
            <label class="block mb-2 font-semibold">Nama Brand</label>
            <div>
                <select name="brand_id" id="brand_id" required
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                    <option value="">-- Pilih Brand --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->namabrand }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Target -->
            <label class="block mb-2 font-semibold mt-4">Nama Target</label>
            <div>
                <select name="target_id" id="target_id" required
                    class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                    <option value="">-- Pilih Target --</option>
                    @foreach($targets as $target)
                        <option value="{{ $target->id }}"> {{ $target->nama_target }} </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Jumlah Target -->
             <label class="block mb-2 font-semibold mt-4">Jumlah Target</label>
            <div>
                <input type="number" name="qty_target" required
                    value="{{ old('qty_target', $target->qty_target ?? '') }}"
                    class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Pilih Bulan -->
            <label class="block mb-2 font-semibold mt-4">Bulan Target</label>
            <input type="month" name="bulan"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                required>

            <!-- Pilih PIC -->
            <label class="block mb-2 font-semibold mt-4">Pilih PIC</label>
            <div id="pic-container" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <p class="text-gray-500 col-span-2 text-sm">Silakan pilih brand terlebih dahulu untuk memunculkan PIC.</p>
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

                <a href="{{ route('getDaftarTargetTimPromotor') }}"
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

        <!-- Script JS AJAX -->
        <script>
            document.getElementById('brand_id').addEventListener('change', function () {
                let brandId = this.value;

                fetch(`/get-pegawais-by-brand/${brandId}`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('pic-container');
                        container.innerHTML = '';

                        if (data.length === 0) {
                            container.innerHTML = '<p class="text-red-500 col-span-2 text-sm">Tidak ada pegawai ditemukan untuk brand ini.</p>';
                            return;
                        }

                        data.forEach(pegawai => {
                            const wrapper = document.createElement('div');
                            wrapper.className = "flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700";

                            const checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'pic_id[]';
                            checkbox.value = pegawai.id;
                            checkbox.id = `pic_${pegawai.id}`;
                            checkbox.className = "w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600";

                            const label = document.createElement('label');
                            label.htmlFor = `pic_${pegawai.id}`;
                            label.innerText = pegawai.namalengkap;
                            label.className = "w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300";

                            wrapper.appendChild(checkbox);
                            wrapper.appendChild(label);
                            container.appendChild(wrapper);
                        });
                    })
                    .catch(() => {
                        document.getElementById('pic-container').innerHTML = '<p class="text-red-500 col-span-2 text-sm">Gagal memuat data pegawai.</p>';
                    });
            });
        </script>
    </div>
</x-layout>