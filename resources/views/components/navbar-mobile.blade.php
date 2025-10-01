<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vinda</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Tambahkan Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <!-- Tambahkan Lucide.js -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gradient-to-br from-pink-50 via-blue-50 to-purple-50 min-h-screen font-sans">

  <!-- Navbar -->
  <nav class="fixed top-0 left-0 w-full bg-white shadow-sm border-b border-pink-100 z-50 p-4" x-data="{ open: false }">
    <ul class="space-y-2 text-sm text-gray-700">

      <!-- Home -->
      <li>
        <a href="/home" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 transition">
          <i data-lucide="home" class="w-4 h-4"></i> Home
        </a>
      </li>

      <!-- Jadwal -->
      <li>
        <a href="/get-jadwal-kerja" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 transition">
          <i data-lucide="calendar" class="w-4 h-4"></i> Jadwal
        </a>
      </li>

      <!-- Dropdown Master Data -->
      <li x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-blue-100 transition">
          <span class="flex items-center gap-2">
            <i data-lucide="target" class="w-4 h-4"></i> Master Data
          </span>
          <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
        </button>
        <ul x-show="open" x-transition class="ml-6 mt-1 space-y-1 border-l border-blue-300/40 pl-3">
          <li>
            <a href="/get-data-toko" class="flex items-center gap-2 py-2 hover:text-blue-600 transition">
              <i data-lucide="shopping-bag" class="w-4 h-4"></i> Daftar Toko
            </a>
          </li>
        </ul>
      </li>

      <!-- Contact -->
      <li>
        <a href="/contact" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 transition">
          <i data-lucide="mail" class="w-4 h-4"></i> Contact
        </a>
      </li>

      <!-- Divider -->
      <hr class="border-blue-300/40 my-3">

      <!-- Options -->
      <li x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 rounded-lg hover:bg-blue-100 transition">
          <span class="flex items-center gap-2">
            <i data-lucide="settings" class="w-4 h-4"></i> Options
          </span>
          <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
        </button>

        <ul x-show="open" x-transition class="ml-6 mt-1 space-y-1 border-l border-blue-300/40 pl-3">
          <li>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 py-2 hover:text-blue-600 transition">
              <i data-lucide="user" class="w-4 h-4"></i> Your Profile
            </a>
          </li>
          <li>
            <a href="{{ route('settings.form') }}" class="flex items-center gap-2 py-2 hover:text-blue-600 transition">
              <i data-lucide="settings" class="w-4 h-4"></i> Settings
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex items-center gap-2 py-2 text-red-400 hover:text-red-500 transition">
                <i data-lucide="log-out" class="w-4 h-4"></i> Sign out
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>

  <!-- Jalankan Lucide -->
  <script>
    lucide.createIcons();
  </script>
</body>
</html>
