<x-layout>
    <x-slot:title>Target Promotor</x-slot:title>
    <div class="p-6 space-y-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <!-- Tombol Input Data -->
            <a href="{{ route('getFormInputTargetPromotor') }}"
               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Data
            </a>

            <!-- Filter Bulan & Tahun -->
            <form method="GET" action="{{ route('getTargetPromotor') }}" class="flex items-center space-x-2">
                <label for="bulan" class="text-sm font-medium text-gray-700">Bulan:</label>
                <select name="bulan" id="bulan"
                    class="rounded px-3 py-2 text-sm bg-white border border-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Bulan --</option>
                    @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <label for="tahun" class="text-sm font-medium text-gray-700">Tahun:</label>
                <select name="tahun" id="tahun"
                    class="rounded px-3 py-2 text-sm bg-white border border-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Semua Tahun --</option>
                    @foreach(range(date('Y'), 2020) as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                    Cari
                </button>
            </form>
        </div>

        <h1 class="text-xl font-bold mb-4">Daftar Target Promotor :</h1>

        <!-- Tabel Daftar Target -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semifold text-gray-900 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-semifold text-gray-900 uppercase tracking-wider">Bulan - Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-semifold text-gray-900 uppercase tracking-wider">Tema Konten</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Jumlah Target</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($targetData as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->namabrand ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($item->bulan)->format('F Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->pic_nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_target ?? '-' }}</td>
                            <td class="px-6 py-4 text-center font-bold text-gray-700">{{ $item->qty_target ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Data tidak tersedia!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
        </div>
    </div>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">Capaian Target Promotor :</h1>

        <!-- Tabel Target Tercapai-->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">PJ BP</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Nama MUA/KOL/KAFE</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Tema Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Platform IG/TikTok</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Link Konten</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($targetData as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->pic_nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_collab ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_target ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->produk ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->platform ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->link_konten ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->ket_tambahan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Data tidak tersedia!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
        </div>
    </div>

</x-layout>
