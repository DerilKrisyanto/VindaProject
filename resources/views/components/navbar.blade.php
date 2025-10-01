<nav 
    x-data="{ isOpen: false, isScrolled: false }"
    x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 10)"
    :class="{
        'glass-effect bg-white/70 shadow-md shadow-blue-100/40': isScrolled,
        'bg-white/90': !isScrolled
    }"
    class="fixed top-0 left-0 right-0 z-50 border-b border-blue-100/50 smooth-transition">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            <!-- Logo -->
            <a href="/home" class="flex items-center gap-3 group">
                <img src="{{ asset('img/logo.svg') }}" alt="Vinda" class="h-12 w-auto smooth-transition group-hover:scale-105">
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-x-2">
                <x-nav-link href="/home" :active="request()->is('home')">
                    <i data-lucide="home" class="w-4 h-4"></i> Home
                </x-nav-link>

                <x-nav-link href="/get-jadwal-kerja" :active="request()->is('index')">
                    <i data-lucide="calendar" class="w-4 h-4"></i> Jadwal
                </x-nav-link>

                <!-- Dropdown Master Data -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="group flex items-center gap-2 px-4 py-2.5 rounded-2xl text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-white/60 smooth-transition">
                        <i data-lucide="database" class="w-4 h-4"></i>
                        Master Data
                        <i data-lucide="chevron-down" class="w-4 h-4 smooth-transition" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-transition
                        class="absolute mt-2 w-56 right-0 origin-top-right bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-blue-100/50 py-2 soft-shadow">
                        @foreach([
                            // ['href' => '/targetbrand', 'icon' => 'star', 'label' => 'BIG EVENT'],
                            // ['href' => '/targettimpromotor', 'icon' => 'users', 'label' => 'Target Tim'],
                            // ['href' => '/targetpromotor', 'icon' => 'user-check', 'label' => 'Target Promotor'],
                            // ['href' => '/daftartargetpromotor', 'icon' => 'list-checks', 'label' => 'Master Target Tim'],
                            ['href' => '/get-data-toko', 'icon' => 'shopping-bag', 'label' => 'Daftar Toko'],
                            ['href' => '/get-data-shift', 'icon' => 'shopping-bag', 'label' => 'Shift Kerja'],
                        ] as $item)
                            <a href="{{ $item['href'] }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50/50 smooth-transition">
                                <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4"></i>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <x-nav-link href="/contact" :active="request()->is('contact')">
                    <i data-lucide="mail" class="w-4 h-4"></i> Contact
                </x-nav-link>
            </div>

            <!-- CTA + Profile (Desktop) -->
            <div class="hidden lg:flex items-center gap-4">
                <!-- Option Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="group flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-medium bg-gradient-to-r from-blue-400 to-blue-500 text-blue shadow-md hover:scale-105 smooth-transition">
                        <i data-lucide="settings" class="w-4 h-4"></i> Options
                        <i data-lucide="chevron-down" class="w-4 h-4 smooth-transition" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-52 origin-top-right bg-white rounded-2xl shadow-xl border border-blue-100 py-2">
                        <a href="{{ route('profile.edit') }}" 
                        class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition">
                            <i data-lucide="user" class="w-5 h-5"></i> Your Profile
                        </a>

                        <a href="{{ route('settings.form') }}" 
                        class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition">
                            <i class="fa fa-address-book-o text-lg"></i> User Account
                        </a>

                        <hr class="my-2 border-blue-100">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:text-red-600 hover:bg-red-50 transition">
                                <i data-lucide="log-out" class="w-5 h-5"></i> Sign out
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Avatar -->
                <div>
                    @php $user = Auth::guard('pegawai')->user(); @endphp
                    @if($user && $user->foto_pegawai)
                        <img src="{{ asset('Pegawai/Profile/' . $user->foto_pegawai) }}" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md soft-shadow-hover hover:scale-105 smooth-transition" />
                    @else
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center shadow-md soft-shadow-hover hover:scale-105 smooth-transition">
                            <i data-lucide="user" class="w-6 h-6 text-blue"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button @click="isOpen = !isOpen"
                class="lg:hidden p-3 rounded-2xl text-slate-600 hover:text-blue-600 hover:bg-white/60 smooth-transition">
                <i data-lucide="menu" class="w-6 h-6" x-show="!isOpen"></i>
                <i data-lucide="x" class="w-6 h-6" x-show="isOpen"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="isOpen" x-transition
         class="lg:hidden border-t border-blue-100/50 bg-blue/90 backdrop-blur-xl px-4 py-6 space-y-3">
        @include('components.navbar-mobile')
    </div>
</nav>

<!-- Spacer -->
<div class="h-20"></div>
