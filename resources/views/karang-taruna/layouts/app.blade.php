<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Karang Taruna - SisaKu')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --bg-primary: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
        }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #f1fdf6 100%);
            min-height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(22, 163, 74, 0.25);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(22, 163, 74, 0.4);
        }

        @keyframes pageLoad {
            from {
                opacity: 0;
                transform: scale(0.98);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes scrollReveal {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-page-load {
            animation: pageLoad 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .scroll-reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: opacity, transform;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .welcome-scroll {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            transition: box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: box-shadow;
        }

        .welcome-scroll.active {
            box-shadow: 0 12px 32px rgba(22, 163, 74, 0.12);
        }

        .text-reveal {
            opacity: 0;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s;
            will-change: opacity;
        }

        .card-content.visible .text-reveal {
            opacity: 1;
        }

        .text-reveal:nth-child(2) {
            transition-delay: 0.2s;
        }

        .text-reveal:nth-child(3) {
            transition-delay: 0.3s;
        }

        .text-reveal:nth-child(4) {
            transition-delay: 0.4s;
        }

        .glass-morphic {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .card-modern {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(22, 163, 74, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-modern:hover {
            transform: translateY(-4px);
            border-color: rgba(22, 163, 74, 0.15);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 12px 24px rgba(22, 163, 74, 0.08);
        }

        button, a, input, select, textarea {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary {
            @apply px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-lg shadow-sm hover:shadow-md hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 inline-flex items-center gap-2 text-sm;
        }

        .btn-secondary {
            @apply px-5 py-2.5 bg-white text-gray-700 font-medium rounded-lg shadow-sm hover:shadow-md border border-gray-200 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200 text-sm;
        }

        .btn-soft {
            @apply px-3 py-1.5 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-all duration-200;
        }

        .fa-solid, .fas { font-family: "Font Awesome 6 Free"; font-weight: 900; }
        .fa-regular, .far { font-family: "Font Awesome 6 Free"; font-weight: 400; }
        .fa-brands, .fab { font-family: "Font Awesome 6 Brands"; font-weight: 400; }

        i.fas, i.far, i.fab {
            display: inline-block;
            vertical-align: middle;
            opacity: 1 !important;
        }

        .gradient-text {
            @apply bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent;
        }

        .nav-pill {
            @apply px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200;
        }

        .nav-pill.active {
            @apply bg-emerald-100 text-emerald-700;
        }

        .nav-pill:not(.active) {
            @apply text-gray-600 hover:text-gray-900;
        }

        .glass-dark {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
        }

        .shadow-modern {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        .border-modern {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-hover {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .shadow-soft {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .shadow-soft-lg {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .gradient-to-br {
            @apply bg-gradient-to-br;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        }

        .gradient-accent {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .gradient-warning {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);
        }

        .icon-box {
            @apply w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 shadow-soft;
        }

        .card-interactive {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-interactive:hover {
            transform: translateY(-2px);
        }

        .responsive-number {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: font-size 0.2s ease;
            line-height: 1.2;
        }

        body {
            transition: background 0.12s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        main {
            animation: fadeInContent 0.22s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            opacity: 0;
            will-change: opacity;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        @keyframes fadeInContent {
            from {
                opacity: 0;
                transform: translateY(1px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            main, body {
                animation: none;
                opacity: 1;
                transition: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false, laporanOpen: false }">
        <!-- Modern Navigation - Header -->
        <nav class="sticky top-0 z-50" @click.away="mobileMenuOpen = false">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-12 py-3">
                <div class="flex items-center gap-6">
                    <!-- Logo - Left Side -->
                    <a href="{{ route('karang-taruna.dashboard') }}" class="flex items-center gap-3 shrink-0 group">
                        <div class="w-11 lg:w-13 h-11 lg:h-13 bg-white/90 backdrop-blur-xl rounded-xl shadow-lg border border-gray-200/50 flex items-center justify-center transition-all duration-300 group-hover:bg-white group-hover:shadow-xl group-hover:scale-105">
                            <img src="{{ asset('storage/images/logo.png') }}" alt="SisaKu" class="w-6 lg:w-8 h-6 lg:h-8">
                        </div>
                        <h1 class="font-bold text-green-700 text-lg lg:text-xl transition-all duration-300 group-hover:text-green-800">SisaKu</h1>
                    </a>

                    <!-- Navigation Menu - Center -->
                    <div class="hidden md:flex items-center gap-3 flex-1 justify-center">
                        <a href="{{ route('karang-taruna.dashboard') }}"
                           class="px-5 py-2.5 rounded-3xl text-sm font-medium transition-all duration-300 backdrop-blur-xl {{ request()->routeIs('karang-taruna.dashboard') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                            <i class="fas fa-home text-xs mr-1.5"></i>Dashboard
                        </a>
                        <a href="{{ route('karang-taruna.warga.index') }}"
                           class="px-5 py-2.5 rounded-3xl text-sm font-medium transition-all duration-300 backdrop-blur-xl {{ request()->routeIs('karang-taruna.warga.*') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                            <i class="fas fa-users text-xs mr-1.5"></i>Warga
                        </a>
                        <a href="{{ route('karang-taruna.transaksi.index') }}"
                           class="px-5 py-2.5 rounded-3xl text-sm font-medium transition-all duration-300 backdrop-blur-xl {{ request()->routeIs('karang-taruna.transaksi.*') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                            <i class="fas fa-exchange-alt text-xs mr-1.5"></i>Transaksi
                        </a>
                        <a href="{{ route('karang-taruna.arus-kas.index') }}"
                           class="px-5 py-2.5 rounded-3xl text-sm font-medium transition-all duration-300 backdrop-blur-xl {{ request()->routeIs('karang-taruna.arus-kas.*') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                            <i class="fas fa-money-bill-wave text-xs mr-1.5"></i>Arus Kas
                        </a>

                        <!-- Clean & Smooth Reports Dropdown -->
                        <div class="relative group ml-2" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                    class="px-5 py-2.5 rounded-3xl text-sm font-medium transition-all duration-300 backdrop-blur-xl flex items-center gap-2 active:scale-95 {{ request()->routeIs('karang-taruna.laporan.*') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                                <i class="fas fa-chart-line text-xs transition-transform duration-200 group-hover:scale-110"></i>
                                <span>Laporan</span>
                                <i class="fas fa-chevron-down text-xs transition-all duration-300 ease-out" :class="open ? 'rotate-180 text-white' : 'group-hover:text-gray-900'"></i>
                            </button>

                            <!-- Dropdown Menu - Consistent Style -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-250"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                                 class="absolute right-0 top-full mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/60 py-3 z-50"
                                 style="display: none;">

                                <!-- Menu Items -->
                                <div class="space-y-1">
                                    <a href="{{ route('karang-taruna.laporan.arus-kas') }}"
                                       @click="open = false"
                                       class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50/80 hover:to-emerald-50/80 hover:text-green-700 transition-all duration-300 ease-out rounded-lg mx-2 group active:scale-95">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                                            <i class="fas fa-chart-bar text-green-600 text-xs group-hover:scale-110 transition-transform duration-200"></i>
                                        </div>
                                        <span class="font-medium">Arus Kas</span>
                                    </a>

                                    <a href="{{ route('karang-taruna.laporan.dampak-lingkungan') }}"
                                       @click="open = false"
                                       class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50/80 hover:to-green-50/80 hover:text-emerald-700 transition-all duration-300 ease-out rounded-lg mx-2 group active:scale-95">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors duration-200">
                                            <i class="fas fa-leaf text-emerald-600 text-xs group-hover:scale-110 transition-transform duration-200"></i>
                                        </div>
                                        <span class="font-medium">Dampak Lingkungan</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Icons - iPhone Style -->
                    <div class="flex items-center gap-3 shrink-0 ml-auto">
                        <!-- Settings Button with Active State -->
                        <a href="{{ route('karang-taruna.pengaturan') }}"
                           class="group relative hidden sm:flex w-12 h-12 items-center justify-center rounded-3xl transition-all duration-300 backdrop-blur-xl active:scale-95 {{ request()->routeIs('karang-taruna.pengaturan*') ? 'bg-green-600 hover:bg-green-700 text-white shadow-xl' : 'bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40' }}">
                            <i class="fas fa-cog text-sm {{ request()->routeIs('karang-taruna.pengaturan*') ? 'rotate-90' : 'group-hover:rotate-90' }} transition-transform duration-300 ease-out"></i>
                        </a>

                        <!-- Clean User Profile Dropdown -->
                        <div class="relative group hidden sm:flex items-center" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 px-4 py-3 rounded-3xl transition-all duration-300 backdrop-blur-xl active:scale-95 bg-gray-100/60 hover:bg-gray-200/70 text-gray-700 hover:text-gray-900 shadow-lg border border-gray-200/40 cursor-pointer">
                                <div class="w-7 h-7 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm group-hover:scale-105 transition-transform duration-200">
                                    {{ substr(Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700 hover:text-gray-900 hidden md:block truncate max-w-[120px] transition-colors duration-200">{{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-700 hover:text-gray-900 transition-all duration-300 ease-out" :class="open ? 'rotate-180 text-gray-900' : ''"></i>
                            </button>

                            <!-- Clean Profile Dropdown - Positioned Below -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-250"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                                 class="absolute right-0 top-full mt-3 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/60 py-3 z-50"
                                 style="display: none;">

                                <!-- Clean User Header -->
                                <div class="px-4 pb-3 mb-2 border-b border-gray-100/80">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                            {{ substr(Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'user@sisaku.id' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Clean Menu Items -->
                                <div class="space-y-1">
                                    <a href="{{ route('karang-taruna.pengaturan') }}"
                                       @click="open = false"
                                       class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50/80 hover:to-emerald-50/80 hover:text-green-700 transition-all duration-300 ease-out rounded-lg mx-2 group active:scale-95">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                                            <i class="fas fa-cog text-green-600 text-xs group-hover:scale-110 transition-transform duration-200"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium">Pengaturan</div>
                                            <div class="text-xs text-gray-500">Kelola akun</div>
                                        </div>
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50/80 transition-all duration-300 ease-out rounded-lg mx-2 group active:scale-95">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors duration-200">
                                                <i class="fas fa-sign-out-alt text-red-600 text-xs group-hover:scale-110 transition-transform duration-200"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium">Logout</div>
                                                <div class="text-xs text-gray-500">Keluar akun</div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu - iPhone Style -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50/80 backdrop-blur-sm text-gray-700 hover:bg-gray-100/80 transition-all duration-300 ease-out active:scale-95 shadow-sm border border-gray-200/30 cursor-pointer">
                            <i class="fas fa-bars text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden"
             style="display: none;"
             @click="mobileMenuOpen = false">
             class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm sm:hidden"
             style="display: none;">

            <!-- Mobile Menu Panel -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-x-full"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform translate-x-full"
                 class="absolute right-0 top-0 h-full w-64 max-w-[75vw] bg-white/95 backdrop-blur-xl shadow-2xl border-l border-gray-200/50"
                 style="display: none;">

                <!-- Mobile Menu Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center">
                            <img src="{{ asset('storage/images/logo.png') }}" alt="SisaKu" class="w-6 h-6">
                        </div>
                        <h2 class="font-bold text-green-700 text-lg">SisaKu</h2>
                    </div>
                    <button @click="mobileMenuOpen = false"
                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-times text-gray-600 text-sm"></i>
                    </button>
                </div>

                <!-- Mobile Menu Content - Minimalist Design -->
                <div class="flex flex-col h-full p-2">
                    <!-- Logo Section -->
                    <div class="px-1 py-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white rounded-lg shadow-md flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-6 h-6">
                            </div>
                            <div class="min-w-0">
                                <h1 class="text-lg font-bold text-green-700 truncate">SisaKu</h1>
                                <p class="text-xs text-gray-400 font-normal mt-0">Karang Taruna</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 overflow-y-auto px-1 custom-scrollbar">
                        <div class="space-y-0.5">
                            <!-- Dashboard -->
                            <a href="{{ route('karang-taruna.dashboard') }}"
                               @click="mobileMenuOpen = false"
                               class="nav-link {{ request()->routeIs('karang-taruna.dashboard') ? 'nav-active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="fas fa-th-large"></i>
                                </div>
                                <span class="nav-label">Dashboard</span>
                            </a>

                            <!-- Warga -->
                            <a href="{{ route('karang-taruna.warga.index') }}"
                               @click="mobileMenuOpen = false"
                               class="nav-link {{ request()->routeIs('karang-taruna.warga.*') ? 'nav-active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span class="nav-label">Warga</span>
                            </a>

                            <!-- Transaksi -->
                            <a href="{{ route('karang-taruna.transaksi.index') }}"
                               @click="mobileMenuOpen = false"
                               class="nav-link {{ request()->routeIs('karang-taruna.transaksi.*') ? 'nav-active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <span class="nav-label">Transaksi</span>
                            </a>

                            <!-- Arus Kas -->
                            <a href="{{ route('karang-taruna.arus-kas.index') }}"
                               @click="mobileMenuOpen = false"
                               class="nav-link {{ request()->routeIs('karang-taruna.arus-kas.*') ? 'nav-active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <span class="nav-label">Arus Kas</span>
                            </a>

                            <!-- Divider -->
                            <div class="nav-divider"></div>

                            <!-- Laporan Group -->
                            <div class="nav-group">
                                <button @click="laporanOpen = !laporanOpen; $event.stopPropagation()"
                                        class="nav-link nav-parent"
                                        :class="laporanOpen ? 'nav-parent-active' : ''">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <span class="nav-label">Laporan</span>
                                    <i class="fas fa-chevron-down nav-chevron"
                                       :class="laporanOpen ? 'rotate-180' : ''"></i>
                                </button>
                                <div class="nav-submenu"
                                     :style="laporanOpen ? 'max-height: 400px; opacity: 1;' : 'max-height: 0; opacity: 0;'"
                                     style="overflow: hidden; transition: all 0.3s ease;">
                                    <a href="{{ route('karang-taruna.laporan.arus-kas') }}"
                                       @click="mobileMenuOpen = false"
                                       class="submenu-link {{ request()->routeIs('karang-taruna.laporan.arus-kas') ? 'submenu-active' : '' }}">
                                        <i class="fas fa-circle submenu-bullet"></i>
                                        <span>Arus Kas</span>
                                    </a>
                                    <a href="{{ route('karang-taruna.laporan.dampak-lingkungan') }}"
                                       @click="mobileMenuOpen = false"
                                       class="submenu-link {{ request()->routeIs('karang-taruna.laporan.dampak-lingkungan') ? 'submenu-active' : '' }}">
                                        <i class="fas fa-circle submenu-bullet"></i>
                                        <span>Dampak Lingkungan</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="nav-divider"></div>

                            <!-- Pengaturan -->
                            <a href="{{ route('karang-taruna.pengaturan') }}"
                               @click="mobileMenuOpen = false"
                               class="nav-link {{ request()->routeIs('karang-taruna.pengaturan*') ? 'nav-active' : '' }}">
                                <div class="nav-icon-wrapper">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="nav-label">Pengaturan</span>
                            </a>

                            <!-- Divider -->
                            <div class="nav-divider"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="nav-link w-full text-left text-red-600 !hover:bg-red-100 !hover:text-red-700">
                                    <div class="nav-icon-wrapper">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <span class="nav-label">Logout</span>
                                </button>
                            </form>
                        </div>
                    </nav>

                    <!-- User Profile Footer -->
                    <div class="px-0.5 py-2.5 border-t border-gray-200/20 mt-auto">
                        <div class="profile-container">
                            <div class="profile-info">
                                <div class="profile-avatar">
                                    {{ substr(Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="profile-name">{{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }}</p>
                                    <p class="profile-role">Karang Taruna</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('karang-taruna.pengaturan') }}"
                                   @click="mobileMenuOpen = false"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors duration-200 text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-cog text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-500 hover:bg-red-600 transition-colors duration-200 text-white hover:text-white" title="Logout">
                                        <i class="fas fa-sign-out-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden pb-8 w-full">
            <div class="max-w-7xl mx-auto w-full px-1 md:px-2 lg:px-3 py-6">
                @yield('content')
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="mt-4 py-3 border-t border-gray-200/50 bg-white/30 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-12 text-center">
                <div class="flex items-center justify-center gap-2">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="SisaKu" class="w-5 h-5">
                    <p class="text-xs text-gray-600">
                        SisaKu 2025 - Kelola Sampah, Jaga Lingkungan
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 sm:top-6 sm:right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

    <style>
        /* Mobile Menu Styling - Similar to Admin Sidebar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(22, 163, 74, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(22, 163, 74, 0.3);
        }

        /* Navigation Links */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 9px;
            border-radius: 8px;
            color: #64748b;
            font-size: 12px;
            font-weight: 400;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: rgba(0, 0, 0, 0.02);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            outline: none;
            position: relative;
        }

        @media (min-width: 640px) {
            .nav-link {
                gap: 10px;
                padding: 8px 11px;
                border-radius: 9px;
                font-size: 13px;
            }
        }

        @media (min-width: 768px) {
            .nav-link {
                gap: 12px;
                padding: 9px 13px;
                border-radius: 10px;
                font-size: 14px;
            }
        }

        .nav-link:hover {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .nav-link.nav-active {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
            font-weight: 500;
            box-shadow: none;
        }

        .nav-icon-wrapper {
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
        }

        @media (min-width: 640px) {
            .nav-icon-wrapper {
                width: 17px;
                height: 17px;
                font-size: 13px;
            }
        }

        @media (min-width: 768px) {
            .nav-icon-wrapper {
                width: 18px;
                height: 18px;
                font-size: 14px;
            }
        }

        .nav-link:hover .nav-icon-wrapper i {
            transform: scale(1.05);
        }

        .nav-link.nav-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: #16a34a;
            border-radius: 0 2px 2px 0;
        }

        .nav-link.nav-parent {
            cursor: pointer;
        }

        .nav-link.nav-parent:hover {
            background: rgba(34, 197, 94, 0.1);
        }

        .nav-link.nav-parent-active {
            background: rgba(34, 197, 94, 0.08);
            color: #16a34a;
            font-weight: 500;
        }

        .nav-label {
            flex: 1;
            word-break: break-word;
        }

        .nav-chevron {
            margin-left: auto;
            font-size: 9px;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            color: #94a3b8;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .nav-chevron {
                font-size: 10px;
            }
        }

        /* Submenu */
        .nav-group {
            margin: 0;
            padding: 0;
        }

        .nav-submenu {
            margin-top: 0;
            margin-left: 14px;
            padding-left: 0;
            border-left: none;
            overflow: hidden;
        }

        @media (min-width: 640px) {
            .nav-submenu {
                margin-left: 16px;
            }
        }

        @media (min-width: 768px) {
            .nav-submenu {
                margin-left: 20px;
            }
        }

        .submenu-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 5px 8px;
            color: #64748b;
            font-size: 11px;
            font-weight: 400;
            border-radius: 7px;
            margin: 1px 0;
            text-decoration: none;
            border: none;
            outline: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(0, 0, 0, 0.02);
        }

        @media (min-width: 640px) {
            .submenu-link {
                gap: 8px;
                padding: 6px 10px;
                font-size: 12px;
                border-radius: 8px;
                margin: 1.5px 0;
            }
        }

        @media (min-width: 768px) {
            .submenu-link {
                gap: 9px;
                padding: 7px 11px;
                font-size: 13px;
                border-radius: 9px;
                margin: 2px 0;
            }
        }

        .submenu-link:hover {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .submenu-link.submenu-active {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
            font-weight: 500;
        }

        .submenu-bullet {
            font-size: 3.5px;
            opacity: 0.5;
            color: #16a34a;
            flex-shrink: 0;
        }

        @media (min-width: 640px) {
            .submenu-bullet {
                font-size: 4px;
            }
        }

        /* Divider */
        .nav-divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.06);
            margin: 4px 0;
            border: none;
            padding: 0;
        }

        @media (min-width: 640px) {
            .nav-divider {
                margin: 5px 0;
            }
        }

        @media (min-width: 768px) {
            .nav-divider {
                margin: 6px 0;
            }
        }

        /* Profile Section */
        .profile-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 9px;
            border-radius: 8px;
            background: rgba(34, 197, 94, 0.08);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(34, 197, 94, 0.12);
            gap: 6px;
        }

        @media (min-width: 640px) {
            .profile-container {
                padding: 9px 10px;
                border-radius: 9px;
                gap: 8px;
            }
        }

        @media (min-width: 768px) {
            .profile-container {
                padding: 10px 11px;
                border-radius: 10px;
                gap: 10px;
            }
        }

        .profile-container:hover {
            background: rgba(34, 197, 94, 0.12);
            border-color: rgba(34, 197, 94, 0.2);
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 7px;
            flex: 1;
            min-width: 0;
        }

        @media (min-width: 640px) {
            .profile-info {
                gap: 8px;
            }
        }

        @media (min-width: 768px) {
            .profile-info {
                gap: 10px;
            }
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: #16a34a;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 11px;
            flex-shrink: 0;
        }

        @media (min-width: 640px) {
            .profile-avatar {
                width: 34px;
                height: 34px;
                border-radius: 8px;
                font-size: 12px;
            }
        }

        @media (min-width: 768px) {
            .profile-avatar {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                font-size: 13px;
            }
        }

        .profile-name {
            font-size: 11px;
            font-weight: 500;
            color: #1f2937;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (min-width: 640px) {
            .profile-name {
                font-size: 11.5px;
            }
        }

        @media (min-width: 768px) {
            .profile-name {
                font-size: 12px;
            }
        }

        .profile-role {
            font-size: 9px;
            font-weight: 400;
            color: #94a3b8;
            margin: 1px 0 0 0;
        }

        @media (min-width: 640px) {
            .profile-role {
                font-size: 9.5px;
                margin: 1.5px 0 0 0;
            }
        }

        @media (min-width: 768px) {
            .profile-role {
                font-size: 10px;
                margin: 2px 0 0 0;
            }
        }

        .logout-button {
            padding: 6px 7px;
            border-radius: 7px;
            color: #ef4444;
            background: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            font-size: 11px;
        }

        @media (min-width: 640px) {
            .logout-button {
                padding: 6.5px 7.5px;
                border-radius: 8px;
                font-size: 12px;
            }
        }

        @media (min-width: 768px) {
            .logout-button {
                padding: 7px 8px;
                border-radius: 8px;
                font-size: 13px;
            }
        }

        .logout-button:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* Icons */
        i.fas, i.far, i.fab {
            opacity: 1 !important;
        }

        html {
            scroll-behavior: smooth;
        }



        .scroll-fade {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .scroll-fade.visible {
            opacity: 1;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const bgColor = type === 'success' ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
            const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const notification = document.createElement('div');
            notification.className = `${bgColor} border-l-4 p-3 sm:p-4 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm pointer-events-auto max-w-md sm:max-w-lg`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="fas ${icon} ${iconColor} text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                    <p class="${textColor} font-medium">${message}</p>
                </div>
            `;

            container.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if (session('success'))
                showNotification('{{ session("success") }}', 'success');
            @endif

            @if (session('error'))
                showNotification('{{ session("error") }}', 'error');
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showNotification('{{ $error }}', 'error');
                @endforeach
            @endif

            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 4000);

            const elements = document.querySelectorAll('[class*="animate-"]');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.06}s`;
            });
        });

        // Password visibility toggle function
        window.togglePassword = function(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('eyeIcon_' + fieldId) || document.getElementById(fieldId + '-icon');

            if (field && icon) {
                if (field.type === 'password') {
                    field.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    field.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        };

        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId + '-submenu');
            const icon = document.getElementById(menuId + '-icon');

            if (submenu && icon) {
                submenu.classList.toggle('show');
                icon.style.transform = submenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        // Auto-open active submenu on page load
        document.addEventListener('DOMContentLoaded', function() {
            const activeSubmenuItems = document.querySelectorAll('.submenu-link.submenu-active');
            activeSubmenuItems.forEach(item => {
                const submenu = item.closest('.nav-submenu');
                if (submenu) {
                    submenu.classList.add('show');
                    const groupId = submenu.id.replace('-submenu', '');
                    const icon = document.getElementById(groupId + '-icon');
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                }
            });

            // Initialize scroll effects
            initScrollEffects();

            // Initialize responsive numbers
            makeNumbersResponsive();
            window.addEventListener('resize', makeNumbersResponsive);
        });

        // Scroll effects function with smooth animation
        function initScrollEffects() {
            // Intersection Observer for scroll-reveal elements
            const revealObserverOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            };

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, revealObserverOptions);

            // Observe elements with scroll-reveal class
            document.querySelectorAll('.scroll-reveal').forEach(el => {
                revealObserver.observe(el);
            });

            // Intersection Observer for scroll-fade elements
            const fadeObserverOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -100px 0px'
            };

            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        fadeObserver.unobserve(entry.target);
                    }
                });
            }, fadeObserverOptions);

            // Observe elements with scroll-fade class
            document.querySelectorAll('.scroll-fade').forEach(el => {
                fadeObserver.observe(el);
            });

            // Text reveal observer - teks dalam card muncul saat scroll
            const textRevealOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const textRevealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        textRevealObserver.unobserve(entry.target);
                    }
                });
            }, textRevealOptions);

            // Observe all card-content containers
            document.querySelectorAll('.card-content').forEach(el => {
                textRevealObserver.observe(el);
            });
        }

        function makeNumbersResponsive() {
            const responsiveElements = document.querySelectorAll('.responsive-number');

            responsiveElements.forEach(element => {
                const card = element.closest('.glass-dark');
                if (!card) return;

                const iconElement = card.querySelector('.w-12.h-12, .w-10, .w-11, .w-12');
                const iconWidth = iconElement ? iconElement.offsetWidth + 20 : 68;

                const text = element.getAttribute('data-value') || element.textContent.trim();
                const cardWidth = card.offsetWidth;
                const padding = 40;
                const availableWidth = cardWidth - padding - iconWidth;

                element.style.fontSize = '';

                const testSpan = document.createElement('span');
                testSpan.style.fontSize = window.getComputedStyle(element).fontSize;
                testSpan.style.fontFamily = window.getComputedStyle(element).fontFamily;
                testSpan.style.fontWeight = window.getComputedStyle(element).fontWeight;
                testSpan.style.position = 'absolute';
                testSpan.style.visibility = 'hidden';
                testSpan.style.whiteSpace = 'nowrap';
                testSpan.textContent = text;
                document.body.appendChild(testSpan);

                const textWidth = testSpan.offsetWidth;
                document.body.removeChild(testSpan);

                const scale = Math.min(1, availableWidth / textWidth);
                const finalScale = Math.max(0.25, scale);

                const originalSize = parseFloat(window.getComputedStyle(element).fontSize);
                const newSize = originalSize * finalScale;

                const minSize = 12;
                const finalSize = Math.max(minSize, newSize);

                element.style.fontSize = `${finalSize}px`;

                if (finalScale < 0.5) {
                    element.style.letterSpacing = '0.5px';
                } else {
                    element.style.letterSpacing = '';
                }
            });
        }

        function initWelcomeScroll() {
            const welcomeCard = document.querySelector('.welcome-scroll');
            if (!welcomeCard) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    } else {
                        entry.target.classList.remove('active');
                    }
                });
            }, { threshold: 0.3 });

            observer.observe(welcomeCard);
        }

        document.addEventListener('DOMContentLoaded', () => {
            initScrollEffects();
            makeNumbersResponsive();
            initWelcomeScroll();
            window.addEventListener('resize', makeNumbersResponsive);
        });
    </script>

    @stack('scripts')

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>
