<x-layout>
    <x-slot:title>User Account</x-slot:title>

    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow space-y-6 mt-6">
        <h2 class="text-center font-bold text-gray-800">Ubah Username & Password</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 font-semibold mt-4">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                       class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('username')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold mt-4">Password Baru</label>
                <input type="password" name="password"
                       class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold mt-4">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
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

                <a href="{{ route('home') }}"
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
    </div>
</x-layout>
