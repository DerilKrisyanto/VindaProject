<style>
    table {
        white-space: nowrap;
        border-collapse: collapse;
        width: 100%;
    }

    /* Container scroll */
    .scroll-container {
        position: relative;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
        width: 100%;
        padding: 10px;
        background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    /* Tombol scroll panah */
    .scroll-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease-in-out;
    }

    .scroll-arrow:hover {
        background-color: rgba(0, 0, 0, 0.8);
        transform: translateY(-50%) scale(1.1);
    }

    .scroll-arrow.left {
        left: 8px;
    }

    .scroll-arrow.right {
        right: 8px;
    }

    /* Gaya tabel */
    table th {
        background: #f1f5f9;
        color: #111827;
        font-weight: 600;
        border: 1px solid #d1d5db;
        text-align: center;
        padding: 6px;
    }

    table td {
        border: 1px solid #e5e7eb;
        padding: 6px 8px;
        text-align: center;
        color: #374151;
        background-color: #fff;
    }

    table tr:nth-child(even) td {
        background-color: #f9fafb;
    }

    table tr:hover td {
        background-color: #eef2ff;
        transition: 0.2s;
    }
</style>

<x-layout>
    <x-slot:title>Jadwal Kerja</x-slot:title>
    <div class="container mx-auto px-2 py-6 relative">
        <h2 class="text-center font-bold text-lg mb-6">REKAP JADWAL KERJA SPG</h2>

        <!-- 🔹 Filter Bulan & Tahun + Tombol Input -->
        <div class="flex flex-wrap justify-between items-end mb-3 text-xs sm:text-sm">

            <!-- 🔸 Form Filter -->
            <form method="GET" action="{{ url('/get-jadwal-kerja') }}" 
                class="flex flex-wrap items-end gap-2">

                <div class="flex flex-col">
                    <label for="bulan" class="text-[10px] sm:text-xs font-semibold mb-0.5">Bulan:</label>
                    <select name="bulan" id="bulan" 
                        class="border border-gray-300 rounded bg-white px-2 py-0.5 text-[10px] sm:text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan', date('n')) == $i ? 'selected' : '' }}>
                                {{ \DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="tahun" class="text-[10px] sm:text-xs font-semibold mb-0.5">Tahun:</label>
                    <select name="tahun" id="tahun" 
                        class="border border-gray-300 rounded bg-white px-2 py-0.5 text-[10px] sm:text-xs focus:outline-none focus:ring-1 focus:ring-blue-400">
                        @for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white text-[10px] sm:text-xs font-semibold px-3 py-1 rounded shadow-sm flex items-center gap-1 transition">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Cari
                    </button>
                </div>

            </form>

            <!-- 🔸 Tombol Input Data -->
            <a href="{{ route('Form.InputJadwalKerja') }}"
                class="inline-flex items-center gap-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[10px] sm:text-xs font-semibold px-3 py-1 rounded shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Data
            </a>
            <!-- 🔸 Tombol Edit Data -->
            <a href="{{ route('Form.EditJadwalKerja') }}"
                class="inline-flex items-center gap-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[10px] sm:text-xs font-semibold px-3 py-1 rounded shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Edit Data
            </a>
        </div>

        <div class="relative">
            <!-- Tombol panah kiri -->
            <button class="scroll-arrow left" id="scrollLeft">&#8592;</button>

            <!-- Pembungkus tabel -->
            <div class="scroll-container" id="scrollContainer">
                <table class="border-collapse border border-gray-300 text-sm min-w-[1200px]">
                    <thead class="bg-gray-100 text-center">
                        <tr>
                            <th class="border p-2" rowspan="2">NO</th>
                            <th class="border p-2" rowspan="2">WILAYAH</th>
                            <th class="border p-2" rowspan="2">CABANG</th>
                            <th class="border p-2" rowspan="2">NAMA TL</th>
                            <th class="border p-2" rowspan="2">NAMA SPG</th>
                            <th class="border p-2" rowspan="2">EVENT</th>
                            <th class="border p-2" rowspan="2">JENIS</th>
                            <th class="border p-2" rowspan="2">NAMA TOKO</th>
                            <th class="border p-2" rowspan="2">STATUS</th>
                            <th class="border p-2" rowspan="2">TAHUN</th>
                            <th class="border p-2" rowspan="2">BULAN</th>
                            <th class="border p-2 text-center" colspan="31">TANGGAL</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 31; $i++)
                                <th class="border p-2">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data as $row)
                            <tr class="text-center">
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $row['wilayah'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['cabang'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['nama_tl'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['nama_spg'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['event'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['jenis'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['nama_toko'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['status'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['tahun'] ?? '-' }}</td>
                                <td class="border p-2">{{ $row['bulan'] ?? '-' }}</td>

                                @for ($i = 1; $i <= 31; $i++)
                                    <td class="border p-2">
                                        {{ $row['jadwal'][$i] ?? '-' }}
                                    </td>
                                @endfor
                            </tr>
                        @empty
                            <tr>
                                <td colspan="43" class="text-center border p-2 text-gray-500">
                                    Tidak ada data untuk bulan & tahun ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tombol panah kanan -->
            <button class="scroll-arrow right" id="scrollRight">&#8594;</button>
        </div>

        <!-- 🔹 Export dengan parameter bulan & tahun -->
        <div class="text-right mt-4">
            <a href="{{ url('/export-jadwal') }}?bulan={{ request('bulan', date('n')) }}&tahun={{ request('tahun', date('Y')) }}" 
                class="bg-green-500 hover:bg-green-600 text-white text-sm px-2.5 py-1 rounded shadow-sm">
                Download to Excel
            </a>
        </div>

    </div>

    <script>
        const scrollContainer = document.getElementById('scrollContainer');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');
        let scrollInterval;

        const SPEED_CLICK = 200; // lebih cepat
        const SPEED_HOLD = 80;   // saat tahan lebih cepat

        function scrollOnce(direction) {
            scrollContainer.scrollLeft += direction * SPEED_CLICK;
        }

        function startScrolling(direction) {
            stopScrolling();
            scrollInterval = setInterval(() => {
                scrollContainer.scrollLeft += direction * SPEED_HOLD;
            }, 10);
        }

        function stopScrolling() {
            clearInterval(scrollInterval);
        }

        scrollRightBtn.addEventListener('click', () => scrollOnce(1));
        scrollRightBtn.addEventListener('mousedown', () => startScrolling(1));
        scrollRightBtn.addEventListener('mouseup', stopScrolling);
        scrollRightBtn.addEventListener('mouseleave', stopScrolling);
        scrollRightBtn.addEventListener('touchstart', () => startScrolling(1));
        scrollRightBtn.addEventListener('touchend', stopScrolling);

        scrollLeftBtn.addEventListener('click', () => scrollOnce(-1));
        scrollLeftBtn.addEventListener('mousedown', () => startScrolling(-1));
        scrollLeftBtn.addEventListener('mouseup', stopScrolling);
        scrollLeftBtn.addEventListener('mouseleave', stopScrolling);
        scrollLeftBtn.addEventListener('touchstart', () => startScrolling(-1));
        scrollLeftBtn.addEventListener('touchend', stopScrolling);
    </script>
</x-layout>
