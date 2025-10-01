<x-layout>
    <x-slot:title>Input Target Promotor</x-slot:title>

    <div class="max-w-5xl mx-auto p-10 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Periode Target :</h2>

        @if (session('gagal'))
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                {{ session('gagal') }}
            </div>
        @endif

        {{-- Filter Bulan dan Tahun --}}
        <form action="{{ route('getFormInputTargetPromotor') }}" method="GET" class="flex items-center gap-2">
            <select name="bulan" required class="border rounded px-2 py-1">
                <option value="">Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>

                @endfor
            </select>

            <select name="tahun" required class="border rounded px-2 py-1">
                <option value="">Tahun</option>
                @for ($i = now()->year; $i >= now()->year - 2; $i--)
                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                Show
            </button>
        </form>

        @if (count($temas) > 0)
            {{-- Form Input Target Promotor --}}
            <form action="{{ route('saveInputTargetPromotor') }}" method="POST" class="mt-6">
                @csrf

                {{-- Hidden input untuk bulan & tahun --}}
                <input type="hidden" name="bulan" value="{{ $selectedBulan }}">
                <input type="hidden" name="tahun" value="{{ $selectedTahun }}">

                {{-- Tema Konten --}}
                <div class="mb-4">
                    <label for="target_id" class="block mb-1 font-semibold">Tema Konten</label>
                    <select name="target_id" id="target_id" required class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                        <option value="">-- Pilih Tema --</option>
                        @foreach ($temas as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->nama_target }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Kolaborator, Produk, Platform, Link, Keterangan --}}
                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Nama MUA / KOL / Kafe</label>
                    <input type="text" name="nama_collab" required class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Produk</label>
                    <input type="text" name="produk" required class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Platform</label>
                    <div class="flex gap-4">
                        <!-- Checkbox Instagram -->
                        <div class="w-1/4 flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700">
                            <input type="checkbox" name="platform[]" value="Instagram" id="platform_instagram"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="platform_instagram"
                                class="py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Instagram</label>
                        </div>

                        <!-- Checkbox Tiktok -->
                        <div class="w-1/4 flex items-center ps-4 border border-gray-200 rounded-sm dark:border-gray-700">
                            <input type="checkbox" name="platform[]" value="Tiktok" id="platform_tiktok"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="platform_tiktok"
                                class="py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tiktok</label>
                        </div>
                    </div>
                </div>



                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Link Konten</label>
                    <input type="text" name="link_konten" required class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]">
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Keterangan</label>
                    <textarea name="ket_tambahan" class="border border-gray-300 rounded p-2 w-full text-sm bg-white h-[42px]"></textarea>
                </div>

                <!-- Simpan & Kembali -->
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

                    <a href="{{ route('getTargetPromotor') }}"
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
        @endif

    </div>
</x-layout>