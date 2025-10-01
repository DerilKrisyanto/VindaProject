<x-layout>
    <x-slot:title>Daftar Target Promotor</x-slot:title>
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Tambah Target Promotor</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Input Target Baru -->
        <form action="{{ route('SaveDaftarTargetPromotor') }}" method="POST" class="mb-6">
            @csrf

            <!-- Input Nama Target -->
            <label class="block font-medium mb-1">Nama Target</label>
            <input type="text" name="nama_target" class="w-full border p-2 rounded mb-4" required>

            <!-- Tombol Aksi -->
            <div class="flex gap-2 mt-4">
                <!-- Tombol Simpan -->
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition w-40 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>

                <!-- Tombol Kembali -->
                <a href="{{ route('getDaftarTargetBrand') }}"
                    class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition w-40 text-center flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </form>


        <h3 class="text-lg font-semibold mb-2">Daftar Nama Target:</h3>

        <div class="overflow-x-auto bg-white rounded shadow border mt-4">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Nama Target</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($targets as $index => $target)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $target->nama_target }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('HapusDaftarTargetPromotor', $target->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layout>
