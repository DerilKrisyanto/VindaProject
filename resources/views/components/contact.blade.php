<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col items-center justify-center text-center py-10 space-y-6">
        <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800">Welcome to My Contact!</h1>
        <p class="text-sm sm:text-base text-gray-600 max-w-md">
            Ini adalah halaman utama Sistem Management Report Vinda. Silakan akses fitur melalui menu yang telah tersedia.
        </p>
        <img src="{{ asset('img/logo.svg') }}" alt="Vinda Logo" class="h-16 sm:h-20 w-auto">
    </div>
</x-layout>
