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
    <x-slot:title>Data Toko</x-slot:title>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Data</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Input Toko Baru -->
        <form action="{{ route('SaveDataToko') }}" method="POST" class="mb-6">
            @csrf

            <!-- Input Nama Toko -->
            <label class="block font-medium mb-1">Nama Toko</label>
            <input type="text" name="namatoko" 
                class="w-full border border-gray-300 rounded p-2 text-sm mb-4 focus:outline-none focus:ring-1 focus:ring-blue-400 bg-white" 
                required>

            <!-- Pilih Wilayah & Cabang Sejajar -->
            <div class="flex flex-wrap gap-3 mb-4">
                <!-- Wilayah -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block mb-1 font-semibold text-sm">Wilayah</label>
                    <select name="objectwilayahfk" id="objectwilayahfk"
                        class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-400" required>
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach($wilayah as $item)
                            <option value="{{ $item->id }}">{{ $item->wilayah }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Cabang -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block mb-1 font-semibold text-sm">Cabang</label>
                    <select name="objectcabangfk" id="objectcabangfk"
                        class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-400" required>
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabang as $item)
                            <option value="{{ $item->id }}">{{ $item->cabang }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-2 mt-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold px-4 py-1.5 rounded shadow-sm flex items-center gap-1.5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>
        </form>

        <h3 class="text-lg font-semibold mb-2">Daftar Toko:</h3>

        <div class="relative">
            <!-- Tombol panah kiri -->
            <button class="scroll-arrow left" id="scrollLeft">&#8592;</button>

            <!-- Pembungkus tabel -->
            <div class="scroll-container" id="scrollContainer">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Nama Toko</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Cabang</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Wilayah</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tokos as $index => $toko)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-center font-semibold text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-left text-gray-700">{{ $toko->namatoko ?? '-' }}</td>
                                <td class="px-6 py-4 text-left text-gray-700">{{ $toko->cabang ?? '-' }}</td>
                                <td class="px-6 py-4 text-left text-gray-700">{{ $toko->wilayah ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('HapusDataToko', $toko->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    Tidak ada data toko ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Tombol panah kanan -->
            <button class="scroll-arrow right" id="scrollRight">&#8594;</button>
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
