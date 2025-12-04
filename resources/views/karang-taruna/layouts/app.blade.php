<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Karang Taruna - SisaKu')</title>
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">

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
            --primary: #10b981;
            --primary-light: #d1fae5;
            --primary-lighter: #ecfdf5;
        }

        body {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            min-height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.5);
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in-down {
            animation: slideInDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-scale-in {
            animation: scaleIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
            border: 1px solid rgba(16, 185, 129, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-modern:hover {
            transform: translateY(-4px);
            border-color: rgba(16, 185, 129, 0.15);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.08);
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
    </style>

    @stack('styles')
</head>
<body>

    <div class="flex flex-col min-h-screen">
        <!-- Modern Navigation - Header -->
        <nav class="sticky top-0 z-50 py-3 bg-white/90 backdrop-blur-lg border-b border-gray-200/40">
            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <div class="flex items-center justify-between gap-6">
                    <!-- Logo - Left Side -->
                    <a href="{{ route('karang-taruna.dashboard') }}" class="flex items-center gap-2.5 shrink-0 group hover:opacity-80 transition-opacity">
                        <img src="{{ asset('build/assets/logo.png') }}" alt="SisaKu" class="w-7 h-7">
                        <h1 class="text-base font-bold text-green-700">SisaKu</h1>
                    </a>

                    <!-- Navigation Menu - Right Side -->
                    <div class="hidden md:flex items-center gap-1 bg-gray-100 rounded-full p-1.5 ml-auto">
                        <a href="{{ route('karang-taruna.dashboard') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ request()->routeIs('karang-taruna.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('karang-taruna.warga.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ request()->routeIs('karang-taruna.warga.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:text-gray-900' }}">
                            Warga
                        </a>
                        <a href="{{ route('karang-taruna.transaksi.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ request()->routeIs('karang-taruna.transaksi.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:text-gray-900' }}">
                            Transaksi
                        </a>
                        <a href="{{ route('karang-taruna.arus-kas.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ request()->routeIs('karang-taruna.arus-kas.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:text-gray-900' }}">
                            Arus Kas
                        </a>

                        <!-- Laporan Dropdown -->
                        <div class="relative group">
                            <button class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ request()->routeIs('karang-taruna.laporan.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:text-gray-900' }} flex items-center gap-1.5">
                                Laporan
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('karang-taruna.laporan.arus-kas') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-chart-line mr-2 text-green-700"></i>Arus Kas
                                </a>
                                <a href="{{ route('karang-taruna.laporan.dampak-lingkungan') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-leaf mr-2 text-green-700"></i>Dampak Lingkungan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Icons -->
                    <div class="flex items-center gap-3 shrink-0">
                        <!-- Settings -->
                        <a href="{{ route('karang-taruna.pengaturan') }}" 
                           class="hidden sm:flex w-9 h-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 transition-all">
                            <i class="fas fa-cog text-sm"></i>
                        </a>

                        <!-- User Profile -->
                        <div class="relative group hidden sm:flex items-center">
                            <button class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-gray-100 transition-all">
                                <div class="w-7 h-7 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 hidden md:block truncate max-w-[120px]">{{ Auth::user()->name ?? 'User' }}</span>
                            </button>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 z-50 mt-10">
                                <div class="px-4 py-2.5 border-b border-gray-200">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email ?? 'user@sisaku.id' }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-all font-medium">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mobile Menu -->
                        <button class="sm:hidden w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all">
                            <i class="fas fa-bars text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden pb-32">
            <div class="max-w-7xl mx-auto px-4 md:px-8 py-6">
                @yield('content')
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="mt-8 py-4 border-t border-gray-200/50 bg-white/30 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 md:px-8 text-center">
                <p class="text-xs text-gray-600">
                    <i class="fas fa-leaf text-emerald-600 mr-1.5"></i>
                    SisaKu © 2024 — Kelola Sampah, Jaga Lingkungan
                </p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-12px)';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 4000);

            const elements = document.querySelectorAll('[class*="animate-"]');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.06}s`;
            });
        });
    </script>

    @stack('scripts')

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>
