<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Vinda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('img/logo.svg') }}">
    <style>
        body {
            background-image: url('{{ asset('img/bg-layout-basic.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row w-full max-w-4xl shadow-lg bg-white rounded-xl overflow-hidden">
        <!-- Left side: Logo and Image -->
        <div class="hidden md:flex md:w-1/2 flex-col items-center justify-center bg-gradient-to-tr from-[#ff006a] to-purple-500 p-6 transition-all duration-300">
            <img src="{{ asset('img/logo.svg') }}" alt="Logo Vinda" class="w-100 h-auto mb-6">
            <p class="text-center text-sm text-gray-100 mt-4 font-semibold px-6"> Selamat datang di Sistem Management Report Vinda </p>
        </div>


        <!-- Right side: Login form -->
        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Masuk ke akun Anda</h2>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('Login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block mb-1 text-sm font-medium text-gray-600">Username</label>
                    <input type="username" id="username" name="username" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-md transition duration-300">
                    Masuk
                </button>
            </form>

            <div class="flex items-center my-6">
                <div class="flex-grow h-px bg-gray-300"></div>
                <span class="px-4 text-sm text-gray-400">atau</span>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar disini</a>
            </p>
        </div>
    </div>
    @if(session('success'))
        <script>alert("{{ session('success') }}"); window.location.href = "{{ route('Login') }}";</script>
    @endif
</body>
</html>
 