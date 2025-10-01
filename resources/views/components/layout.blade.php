<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="{{ asset('img/logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>{{ $title ?? 'Vinda' }}</title>

    <!-- Custom Soft UI -->
    <style>
        .soft-shadow {
            box-shadow: 0 8px 32px rgba(139, 195, 247, 0.12), 0 2px 8px rgba(139, 195, 247, 0.08);
        }
        .soft-shadow-hover:hover {
            box-shadow: 0 12px 48px rgba(139, 195, 247, 0.15), 0 4px 16px rgba(139, 195, 247, 0.1);
        }
        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .neumorphism {
            background: linear-gradient(145deg, #f8fafc, #e2e8f0);
            box-shadow: 
                20px 20px 40px rgba(139, 195, 247, 0.1),
                -20px -20px 40px rgba(255, 255, 255, 0.8);
        }
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="h-full font-sans text-slate-700 antialiased relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50" style="font-family: 'Inter', sans-serif;">
    
    <!-- Soft Gradient Background -->
    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/80 via-slate-50/60 to-purple-50/80"></div>
        <div class="absolute inset-0 opacity-30 bg-center bg-cover bg-no-repeat bg-fixed"
             style="background-image: url('{{ asset('img/bg-layout-basic.png') }}');">
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen relative z-10 flex flex-col">
        <x-navbar />

        @isset($title)
            <x-header>{{ $title }}</x-header>
        @endisset

        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
