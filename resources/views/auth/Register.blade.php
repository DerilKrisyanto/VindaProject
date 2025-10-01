<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Vinda</title>
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
            <p class="text-center text-sm text-gray-100 mt-4 font-semibold px-6"> Selamat datang di Sistem Management Report Vinda</p>
        </div>

        <!-- Right side: Login form -->
        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Akun Baru</h2>

            <form method="POST" action="{{ route('TambahUserBaru') }}" enctype="multipart/form-data" onsubmit="return validateForm();"
                class="space-y-6">
                @csrf

                <div>
                    <h3 class="text-lg font-semibold text-blue-600 border-b border-dashed border-gray-300 pb-1 text-center">Data Pegawai</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <input type="text" name="namalengkap" id="namalengkap" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">No Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Brand</label>
                        <select name="userbrand" id="userbrand" required
                             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">--- Pilih Brand ---</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->namabrand }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Jenis Pegawai</label>
                        <select name="jenispegawai_id" id="jenispegawai_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">--- Pilih Jenis Pegawai ---</option>
                            @foreach($jenispegawai as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->jenispegawai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="relative" id="statusContainer" style="display: none;">
                        <label class="block mb-1 text-sm font-medium text-gray-600">Status Pegawai</label>
                        <select name="objectstatuspegawaifk" id="objectstatuspegawaifk" required
                             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">--- Pilih Status Pegawai ---</option>
                            @foreach($statuspegawai as $status)
                                <option value="{{ $status->id }}">{{ $status->statuspegawai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="relative" id="tokoContainer" style="display: none;">
                        <label class="block mb-1 text-sm font-medium text-gray-600">Nama Toko</label>

                        <!-- Tombol utama -->
                        <button id="dropdownButton"
                            type="button"
                            class="w-full flex justify-between items-center px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <span>Pilih Toko</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Daftar checkbox (dropdown menu) -->
                        <div id="dropdownList"
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto p-2">
                            @foreach($namatoko as $toko)
                                <label class="flex items-center space-x-2 py-1 hover:bg-gray-100 rounded">
                                    <input type="checkbox" name="toko_id[]" value="{{ $toko->id }}" class="form-checkbox">
                                    <span>{{ $toko->namatoko }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <script>
                        const btn = document.getElementById('dropdownButton');
                        const list = document.getElementById('dropdownList');
                        const tokoContainer = document.getElementById('tokoContainer');
                        const statusContainer = document.getElementById('statusContainer');

                        // Event untuk buka/tutup dropdown saat tombol diklik
                        btn.addEventListener('click', () => {
                            list.classList.toggle('hidden');
                        });

                        // Tutup dropdown saat klik di luar
                        document.addEventListener('click', (e) => {
                            if (!btn.contains(e.target) && !list.contains(e.target)) {
                                list.classList.add('hidden');
                            }
                        });

                        // --- Logika tampilkan dropdown hanya jika pilih SPG ---
                        const jenisPegawaiSelect = document.getElementById('jenispegawai_id'); // pastikan id ini ada di select jenis pegawai

                        if (jenisPegawaiSelect) {
                            jenisPegawaiSelect.addEventListener('change', function () {
                                const selectedText = this.options[this.selectedIndex].text.toLowerCase();
                                if (selectedText.includes('spg')) {
                                    tokoContainer.style.display = 'block';
                                    statusContainer.style.display = 'block';
                                } else {
                                    tokoContainer.style.display = 'none';
                                    statusContainer.style.display = 'none';
                                    list.classList.add('hidden');
                                    // reset pilihan checkbox jika ingin
                                    document.querySelectorAll('input[name="toko_id[]"]').forEach(cb => cb.checked = false);
                                }
                            });
                        }
                    </script>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Email</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Foto Profile</label>
                        <input type="file" name="foto_pegawai"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 h-[42px] file:h-full file:py-2 file:px-4 file:border-0 file:bg-blue-100 file:text-blue-700 file:rounded-lg" />
                        @if ($errors->has('foto_pegawai'))
                            <span class="text-red-600 text-sm">{{ $errors->first('foto_pegawai') }}</span>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-blue-600 border-b border-dashed border-gray-300 pb-1 text-center">Data Login</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Username</label>
                        <input type="text" name="username" id="username" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @if ($errors->has('username'))
                            <span class="text-red-600 text-sm">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-600">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow-md transition duration-300">
                        Daftar Akun
                    </button>
                </div>

                <div class="flex items-center my-6">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="px-4 text-sm text-gray-400">atau</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun?
                    <a href="{{ route('Login') }}" class="text-blue-600 hover:underline font-medium">Login disini</a>
                </p>
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            const nama = document.getElementById('namalengkap').value.trim();
            const telp = document.getElementById('no_telepon').value.trim();
            const email = document.getElementById('email').value.trim();
            const user = document.getElementById('username').value.trim();
            const pass = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            if (!nama || !telp || !email || !user || !pass || !confirm) {
                alert('Harap isi semua field!');
                return false;
            }

            if (pass !== confirm) {
                alert('Password dan Konfirmasi Password tidak sama!');
                return false;
            }

            const fileInput = document.getElementById('foto_pegawai');
            if (fileInput && fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/svg+xml'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak didukung. Gunakan JPEG, PNG, JPG, GIF, atau SVG.');
                return false;
            }
        }

            return true;
        }

        
    </script>
    @if(session('error'))
        <script>alert("{{ session('error') }}");</script>
    @endif

    @if(session('success'))
        <script>alert("{{ session('success') }}"); window.location.href = "{{ route('Login') }}";</script>
    @endif
</body>
</html>
