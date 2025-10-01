<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="p-6 space-y-4">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <!-- Tombol Input Data -->
            <a href="{{ route('getInputTargetTimPromotor') }}"
               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Data
            </a>

            <!-- Filter Bulan & Tahun -->
            <form method="GET" action="{{ route('getDaftarTargetTimPromotor') }}" class="flex items-center space-x-2">
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

        <div class="w-full p-4 bg-white shadow overflow-hidden sm:rounded-lg border">
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">#</th>
                            @foreach ($targets as $target)
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                    {{ $target->nama_target }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">Target Event</td>
                            @foreach ($targets as $target)
                                <td class="px-6 py-4 text-center text-gray-700 font-semibold">
                                    {{ $dataPerTarget[$target->id]['qty_target'] ?? '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">PIC</td>
                            @foreach ($targets as $target)
                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ $dataPerTarget[$target->id]['pic_nama'] ?? '-' }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">Plan & Relasi Event</td>
                            @foreach ($targets as $target)
                                <td class="px-6 py-4 text-center text-gray-700">
                                    {{ $dataPerTarget[$target->id]['relasi'] ?? '-' }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Download data Excel -->
        <form action="{{ route('getDownloadTargetTimPromotor') }}" method="GET" class="mt-2">
            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
            <button type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition w-32 text-center flex items-center justify-center gap-2">
                <i class="fa fa-download"></i>
                Download
            </button>
        </form>

    </div>
</x-layout>
