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
    </style>

    @stack('styles')
</head>
<body>

    <div class="flex flex-col min-h-screen">
        <!-- Modern Navigation - Header -->
        <nav class="sticky top-0 z-50 py-3 bg-white/90 backdrop-blur-lg border-b border-gray-200/40">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-12">
                <div class="flex items-center justify-between gap-6">
                    <!-- Logo - Left Side -->
                    <a href="{{ route('karang-taruna.dashboard') }}" class="flex items-center gap-2.5 shrink-0 group hover:opacity-80 transition-opacity">
                        <div class="w-10 lg:w-12 h-10 lg:h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                            <img src="{{ asset('build/assets/logo.png') }}" alt="SisaKu" class="w-6 lg:w-8 h-6 lg:h-8">
                        </div>
                        <h1 class="font-bold text-green-700 text-lg lg:text-xl">SisaKu</h1>
                    </a>

                    <!-- Navigation Menu - Right Side -->
                    <div class="hidden md:flex items-center gap-1 bg-gray-50 rounded-full p-1.5 ml-auto shadow-sm border border-gray-200/50">
                        <a href="{{ route('karang-taruna.dashboard') }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('karang-taruna.dashboard') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-white/60' }}">
                            <i class="fas fa-home text-xs mr-1.5"></i>Dashboard
                        </a>
                        <a href="{{ route('karang-taruna.warga.index') }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('karang-taruna.warga.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-white/60' }}">
                            <i class="fas fa-users text-xs mr-1.5"></i>Warga
                        </a>
                        <a href="{{ route('karang-taruna.transaksi.index') }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('karang-taruna.transaksi.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-white/60' }}">
                            <i class="fas fa-exchange-alt text-xs mr-1.5"></i>Transaksi
                        </a>
                        <a href="{{ route('karang-taruna.arus-kas.index') }}"
                           class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('karang-taruna.arus-kas.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-white/60' }}">
                            <i class="fas fa-money-bill-wave text-xs mr-1.5"></i>Arus Kas
                        </a>

                        <!-- Improved Reports Dropdown -->
                        <div class="relative group px-1" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('karang-taruna.laporan.*') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm' : 'text-gray-700 hover:text-gray-900 hover:bg-white/60' }}">
                                <i class="fas fa-chart-line text-xs"></i>
                                <span>Laporan</span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Enhanced Dropdown Menu -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95 translate-y-1"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 translate-y-1"
                                 class="absolute right-0 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200/80 py-2 z-50 backdrop-blur-sm"
                                 style="display: none;">

                                <div class="px-3 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Menu Laporan</p>
                                </div>

                                <a href="{{ route('karang-taruna.laporan.arus-kas') }}"
                                   @click="open = false"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700 transition-all duration-200 rounded-lg mx-2 group">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                                        <i class="fas fa-chart-bar text-green-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">Arus Kas</div>
                                        <div class="text-xs text-gray-500">Laporan keuangan</div>
                                    </div>
                                </a>

                                <a href="{{ route('karang-taruna.laporan.dampak-lingkungan') }}"
                                   @click="open = false"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 transition-all duration-200 rounded-lg mx-2 group">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors duration-200">
                                        <i class="fas fa-leaf text-emerald-600 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">Dampak Lingkungan</div>
                                        <div class="text-xs text-gray-500">Laporan lingkungan</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Icons - iPhone Style -->
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Settings Button with Active State -->
                        <a href="{{ route('karang-taruna.pengaturan') }}"
                           class="group relative hidden sm:flex w-10 h-10 items-center justify-center rounded-xl transition-all duration-300 ease-out active:scale-95 {{ request()->routeIs('karang-taruna.pengaturan*') ? 'text-green-600 bg-green-50/80' : 'text-gray-600 hover:text-green-600' }}">
                            <div class="absolute inset-0 rounded-xl bg-green-500/0 group-active:bg-green-500/20 transition-all duration-200 ease-out"></div>
                            <i class="fas fa-cog text-sm relative z-10 {{ request()->routeIs('karang-taruna.pengaturan*') ? 'rotate-90' : 'group-hover:rotate-90' }} transition-transform duration-300 ease-out"></i>
                        </a>

                        <!-- User Profile - Enhanced iPhone Style -->
                        <div class="relative group hidden sm:flex items-center" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open"
                                    class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-gray-50/80 transition-all duration-300 ease-out active:scale-95 backdrop-blur-sm cursor-pointer">
                                <div class="w-7 h-7 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                    {{ substr(Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900 hidden md:block truncate max-w-[120px]">{{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-gray-600 transition-all duration-200" :class="open ? 'rotate-180 text-gray-600' : ''"></i>
                            </button>

                            <!-- Modern Profile Dropdown -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                                 class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 py-4 z-50"
                                 style="display: none;">

                                <!-- User Info Section -->
                                <div class="px-5 pb-4 border-b border-gray-100/80">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                            {{ substr(Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? 'user@sisaku.id' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="px-3 py-2">
                                    <a href="{{ route('karang-taruna.pengaturan') }}"
                                       @click="open = false"
                                       class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-gray-50/80 transition-all duration-200 rounded-xl active:scale-95">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-cog text-gray-600 text-xs"></i>
                                        </div>
                                        <span class="font-medium">Pengaturan</span>
                                    </a>
                                </div>

                                <!-- Logout Section -->
                                <div class="px-3 pt-2 border-t border-gray-100/80">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50/80 transition-all duration-200 font-medium rounded-xl active:scale-95">
                                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-sign-out-alt text-red-600 text-xs"></i>
                                            </div>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu - iPhone Style -->
                        <button class="sm:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50/80 backdrop-blur-sm text-gray-700 hover:bg-gray-100/80 transition-all duration-300 ease-out active:scale-95 shadow-sm border border-gray-200/30 cursor-pointer">
                            <i class="fas fa-bars text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden pb-8 w-full">
            <div class="w-full px-4 md:px-6 lg:px-12 py-6">
                @yield('content')
            </div>
        </main>

        <!-- Modern Footer -->
        <footer class="mt-4 py-3 border-t border-gray-200/50 bg-white/30 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-12 text-center">
                <div class="flex items-center justify-center gap-2">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="SisaKu" class="w-5 h-5">
                    <p class="text-xs text-gray-600">
                        SisaKu 2025 - Kelola Sampah, Jaga Lingkungan
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 sm:top-6 sm:right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

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
    </script>

    @stack('scripts')

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>
