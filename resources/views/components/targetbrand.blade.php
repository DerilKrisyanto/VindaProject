<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="p-6 space-y-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <!-- Tombol Input Data -->
            <a href="{{ route('getFormInputTargetBrand') }}"
               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Data
            </a>

            <!-- Filter Bulan & Tahun -->
            <form method="GET" action="{{ route('getDaftarTargetBrand') }}" class="flex items-center space-x-2">
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

        <!-- TABEL DATA -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Brand</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Promotor</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Event</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Local Partner</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Media</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Link Media</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Nama Toko</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Bentuk Kolaborasi</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Detail Kolaborasi</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Qty keluar</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Hasil Kolaborasi</th>
                        <th class="px-6 py-3 text-center text-xs font-semifold text-gray-900 uppercase tracking-wider">Dokumentasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($targetbrands as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-700">
                                <div class="flex gap-2 justify-center">
                                    <a href="{{ route('targetbrand.edit', $item->id) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs transition">Edit</a>
                                    <form action="{{ route('targetbrand.hapus', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-900 font-semibold">{{ $targetbrands->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $item->namabrand }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $item->pic_nama }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_event }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->local_partner }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_media }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->link_media }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->nama_toko }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $item->bentuk_kolaborasi }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $item->detail_kolaborasi }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $item->qty_keluar }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ number_format($item->hasil_kolaborasi, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-700 text-center">
                                @if($item->dokumentasi)
                                    <img src="{{ asset('dokumentasi_target/' . $item->dokumentasi) }}" alt="Dokumentasi" class="h-16 mx-auto rounded shadow">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $targetbrands->links() }}
            </div>
        </div>
        
    </div>
</x-layout>
