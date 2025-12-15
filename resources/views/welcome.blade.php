<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SisaKu - Sistem Bank Sampah Digital</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

        <style>
            * { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
            body { overflow-x: hidden; }

            .card-hover {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                position: relative;
                overflow: hidden;
                will-change: transform, box-shadow;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(16, 185, 129, 0.12);
            }



            .faq-item {
                border-bottom: 1px solid #e5e7eb;
                transition: all 0.3s ease;
            }
            .faq-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            .faq-item.active .faq-content {
                max-height: 300px;
            }
            .faq-item.active .faq-icon {
                transform: rotate(180deg);
            }
            .faq-icon {
                transition: transform 0.3s ease;
            }

            .stat-card {
                animation: countUp 0.6s ease forwards;
            }
            @keyframes countUp {
                from { opacity: 0; transform: translateY(20px) scale(0.9); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }

            .float-element {
                animation: float 3s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .pulse-glow {
                animation: pulse-glow 3s ease-in-out infinite;
                will-change: box-shadow;
            }
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 10px rgba(34, 197, 94, 0.2); }
                50% { box-shadow: 0 0 20px rgba(34, 197, 94, 0.4); }
            }

            .slide-in-left {
                animation: slideInLeft 0.8s ease forwards;
            }
            @keyframes slideInLeft {
                from { transform: translateX(-50px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            .slide-in-right {
                animation: slideInRight 0.8s ease forwards;
            }
            @keyframes slideInRight {
                from { transform: translateX(50px); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }

            .glass-morphism {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .hover-lift {
                transition: transform 0.15s ease, box-shadow 0.15s ease;
                will-change: transform, box-shadow;
            }
            .hover-lift:hover {
                transform: translateY(-2px) translateZ(0);
                box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            }

            /* Admin Dashboard Styles */
            .glass-dark { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
            .shadow-modern { box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); }
            .shadow-soft { box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); }
            .border-modern { border: 1px solid rgba(255, 255, 255, 0.5); }

            @keyframes scale-in {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }

            .animate-scale-in {
                animation: scale-in 0.5s ease-out forwards;
                opacity: 0;
            }

            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            }

            /* Responsive number styling */
            .responsive-number {
                white-space: nowrap;
                transition: font-size 0.2s ease;
                line-height: 1.2;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-slate-50 via-gray-50 to-slate-50 text-gray-800 min-h-screen overflow-x-hidden">

        <nav id="mainNav" class="w-full fixed top-0 left-0 right-0 z-50 flex items-center justify-between md:justify-center pt-4 sm:pt-6 px-4 sm:px-6 md:px-0 transition-all duration-500">
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 hover:bg-white/10 rounded-lg transition-all duration-200 backdrop-blur-sm">
                <i class="fas fa-bars text-white text-lg"></i>
            </button>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-6 lg:gap-8 bg-white shadow-lg rounded-full px-8 lg:px-10 py-3 border border-gray-200 nav-container transition-all duration-500">
                <div class="flex items-center gap-1.5">
                    <div class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 bg-white rounded-lg sm:rounded-xl shadow-md flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-4 sm:w-5 md:w-6 h-4 sm:h-5 md:h-6">
                    </div>
                    <span class="font-bold text-green-700 text-sm sm:text-base">SisaKu</span>
                </div>
                <a href="#beranda" class="text-sm text-gray-700 hover:text-green-600 transition-all duration-200 font-medium">Beranda</a>
                <a href="#fitur" class="text-sm text-gray-700 hover:text-green-600 transition-all duration-200 font-medium">Fitur</a>
                <a href="#tentang" class="text-sm text-gray-700 hover:text-green-600 transition-all duration-200 font-medium">Tentang</a>
                <a href="#faq" class="text-sm text-gray-700 hover:text-green-600 transition-all duration-200 font-medium">FAQ</a>
                <a href="#kontak" class="text-sm text-gray-700 hover:text-green-600 transition-all duration-200 font-medium">Kontak</a>
                <a href="{{ route('login') }}" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-full transition-all duration-300 font-medium">Mulai Sekarang</a>
            </div>

            <!-- Mobile Logo (centered) -->
            <div class="md:hidden flex items-center gap-1.5 flex-1 justify-center">
                <div class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 bg-white rounded-lg sm:rounded-xl shadow-md flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-4 sm:w-5 md:w-6 h-4 sm:h-5 md:h-6">
                </div>
                <span class="font-bold text-white text-sm sm:text-base drop-shadow-sm">SisaKu</span>
            </div>

            <!-- Mobile Menu Close Button -->
            <button id="mobileMenuCloseBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 hover:bg-white/10 rounded-lg hidden transition-all duration-200 backdrop-blur-sm">
                <i class="fas fa-times text-white text-lg"></i>
            </button>
        </nav>

        <!-- Mobile Menu Drawer -->
        <div id="mobileMenuDrawer" class="fixed top-0 right-0 h-screen w-56 bg-white shadow-2xl z-40 transform translate-x-full transition-transform duration-300 md:hidden">
            <div class="flex flex-col h-full p-3">
                <button onclick="toggleMobileMenu()" class="self-end p-2 hover:bg-gray-100 rounded-lg transition-colors mb-2">
                    <i class="fas fa-times text-gray-700 text-lg"></i>
                </button>
                <div class="flex-1 flex flex-col gap-2">
                    <a href="#beranda" onclick="toggleMobileMenu()" class="text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium px-3 py-2 rounded-lg transition-all text-sm">Beranda</a>
                    <a href="#fitur" onclick="toggleMobileMenu()" class="text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium px-3 py-2 rounded-lg transition-all text-sm">Fitur</a>
                    <a href="#tentang" onclick="toggleMobileMenu()" class="text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium px-3 py-2 rounded-lg transition-all text-sm">Tentang</a>
                    <a href="#faq" onclick="toggleMobileMenu()" class="text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium px-3 py-2 rounded-lg transition-all text-sm">FAQ</a>
                    <a href="#kontak" onclick="toggleMobileMenu()" class="text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium px-3 py-2 rounded-lg transition-all text-sm">Kontak</a>
                </div>
                <a href="{{ route('login') }}" class="w-full px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-center rounded-lg font-medium text-sm transition-colors">Mulai Sekarang</a>
            </div>
        </div>

        <script>
            function toggleMobileMenu() {
                const drawer = document.getElementById('mobileMenuDrawer');
                const openBtn = document.getElementById('mobileMenuBtn');
                const closeBtn = document.getElementById('mobileMenuCloseBtn');
                drawer.classList.toggle('translate-x-full');
                openBtn.classList.toggle('hidden');
                closeBtn.classList.toggle('hidden');
            }

            // Navigation stays consistent - no changes on scroll
            // Buttons remain visible with consistent text colors
        </script>

        <section id="beranda" class="relative w-full h-80 sm:h-96 md:h-[480px] bg-cover bg-center max-w-6xl mx-auto mt-24 sm:mt-28 rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden parallax-bg" data-aos="fade-up" style="background-image: url('{{ asset('storage/images/sampah.jpg') }}'); contain-intrinsic-size: 480px;">
            <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-black/30 to-black/20"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4 sm:px-6">
                <div class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-normal leading-tight mb-4 sm:mb-6 text-white">
                    <div id="typewriterLine1" style="min-height: 1.2em;"></div>
                    <div id="typewriterLine2" style="min-height: 1.2em;"></div>
                </div>
                <p class="text-sm sm:text-base md:text-lg lg:text-xl max-w-3xl mx-auto mb-6 sm:mb-12 text-gray-100 slide-in-left">
                    Catat, kelola, dan analisis data sampah secara mudah dalam satu platform pintar yang dirancang untuk Bank Sampah dan Pemerintah Desa.
                </p>
                <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-6 slide-in-right">
                    <a href="{{ route('login') }}" class="bg-white text-green-600 px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-xs sm:text-sm shadow-xl hover:shadow-2xl hover:scale-110 transition-all pulse-glow hover-lift">Mulai Sekarang</a>
                    <a href="#fitur" class="border-2 border-white text-white px-6 sm:px-8 py-3 sm:py-4 rounded-full font-semibold text-xs sm:text-sm hover:bg-white hover:text-green-600 transition-all glass-morphism hover-lift">Pelajari Lebih</a>
                </div>
            </div>
        </section>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-12 sm:mt-16 relative z-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                <!-- Total Sampah -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0s;">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Sampah</p>
                            <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalSampahKg, 0, ',', '.') }} kg">{{ number_format($totalSampahKg, 0, ',', '.') }}<span class="text-xs sm:text-sm text-gray-500"> kg</span></h3>
                            <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Sampah Terkumpul</p>
                        </div>
                        <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-weight text-green-600 text-base sm:text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Kas Masuk -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Masuk</p>
                            <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}">Rp {{ number_format($totalKasMasuk, 0, ',', '.') }}</h3>
                            <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Pemasukan</p>
                        </div>
                        <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-arrow-trend-up text-green-600 text-base sm:text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Warga -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Warga</p>
                            <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalWarga, 0, ',', '.') }}">{{ number_format($totalWarga, 0, ',', '.') }}</h3>
                            <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Warga Terdaftar</p>
                        </div>
                        <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-users text-green-600 text-base sm:text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>

                <!-- CO₂e Dikurangi -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.15s;">
                    <div class="flex justify-between items-start">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">CO₂e Dikurangi</p>
                            <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalCO2, 2, ',', '.') }} kg CO₂e">{{ number_format($totalCO2, 2, ',', '.') }}<span class="text-xs sm:text-sm text-gray-500"> kg CO₂e</span></h3>
                            <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Emisi Karbon</p>
                        </div>
                        <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-leaf text-green-600 text-base sm:text-lg md:text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-16 bg-gradient-to-b from-white to-green-50">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-600">
                    Mengapa Memilih <span class="text-green-700">SisaKu</span>?
                </h3>
                <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">
                    Kami hadir untuk menjawab satu tantangan: bagaimana mengubah sisa menjadi nilai. <span class="text-green-700">SisaKu</span> memadukan teknologi, desain, dan prinsip circular economy untuk menciptakan produk yang elegant tanpa mengganggu jejak besar pada bumi.
                </p>
            </div>
        </section>

        <section id="fitur" class="py-20 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-600">Semua Yang Anda Butuhkan</h3>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">Fitur-fitur canggih yang dirancang untuk merevolusi pengelolaan sampah di komunitas Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover glass-morphism" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-database text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Kelola Bank Sampah</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Sistem pencatatan dan manajemen bank sampah yang mudah dan terintegrasi dengan fitur analitik real-time.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover glass-morphism" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-chart-line text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Kelola Data Pengguna</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Kelola data warga dan nasabah dengan aman. Lacak riwayat transaksi dan kontribusi setiap anggota.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-3 glass-morphism">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Kelola Warga</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Dashboard khusus untuk mengelola data warga, tracking kontribusi, dan laporan dampak lingkungan.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover glass-morphism" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-receipt text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Catat Transaksi Sampah</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Catat setiap transaksi sampah secara detail. Lacak berat, jenis, dan nilai ekonomi dari setiap transaksi.</p>
                    </div>



                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover glass-morphism" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-file-invoice text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Laporan Keuangan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Generate laporan keuangan otomatis. Visualisasi arus kas yang mudah dipahami untuk transparansi maksimal.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover glass-morphism" data-aos="fade-up" data-aos-delay="500">
                        <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-chart-pie text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Laporan Dampak Lingkungan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Ukur dampak nyata program bank sampah terhadap lingkungan. Dashboard CO₂e, volume waste, dan kontribusi berkelanjutan.</p>
                    </div>

                    <div class="bg-green-600 p-8 rounded-3xl shadow-xl card-hover text-white glass-morphism" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-3xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-robot text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3">Chatbot AI</h4>
                        <p class="text-green-50 text-sm leading-relaxed">Chatbot cerdas yang siap membantu menjawab pertanyaan Anda tentang pengelolaan sampah dan memberikan panduan penggunaan platform.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="py-16 bg-gradient-to-br from-green-50 to-emerald-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-up">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">Metrik Utama yang Menggambarkan Dampak Kami</h3>
                        <p class="text-gray-600 text-base md:text-lg mb-6">Jelajahi data yang menunjukkan bagaimana <span class="text-green-700">SisaKu</span> meningkatkan efisiensi pengelolaan sampah anorganik dan menciptakan transparansi kas di tingkat komunitas Anda.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-7 py-3 rounded-full font-semibold text-sm shadow-lg shadow-green-500/30 hover:shadow-xl hover:scale-105 transition-all">
                            Mulai Sekarang
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                        <div class="bg-green-100 rounded-2xl p-6 border-2 border-green-200 transform hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold text-green-700 mb-1">75%+</div>
                            <div class="text-xs text-green-700 font-medium">Efisiensi Pengelolaan Sampah</div>
                        </div>
                        <div class="bg-emerald-100 rounded-2xl p-6 border-2 border-emerald-200 transform hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold text-emerald-700 mb-1">120+</div>
                            <div class="text-xs text-emerald-700 font-medium">Integrated Bank Sampah</div>
                        </div>
                        <div class="bg-teal-100 rounded-2xl p-6 border-2 border-teal-200 transform hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold text-teal-700 mb-1">10K+</div>
                            <div class="text-xs text-teal-700 font-medium">Mentorship Awarded</div>
                        </div>
                        <div class="bg-green-200 rounded-2xl p-6 border-2 border-green-300 transform hover:scale-105 transition-transform">
                            <div class="text-3xl font-bold text-green-800 mb-1">90%</div>
                            <div class="text-xs text-green-800 font-medium">Akurasi Analisa Dampak</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-10">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-600">Sistem Pencatatan Sampah Terintegrasi & Dampak Lingkungan</h3>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">Alur kerja komprehensif yang menunjukkan bagaimana sampah diproses dari pengumpulan hingga pelaporan dampak lingkungan di Desa Bojongsoang.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 md:p-10 border border-green-100" data-aos="fade-up">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-3 shadow-md float-element">
                                <i class="fas fa-hand-holding text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Warga Menyerahkan Sampah</h5>
                            <p class="text-xs text-gray-600">Warga menyerahkan sampah anorganik</p>
                        </div>

                        <div class="text-center">
            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.2s">
                                <i class="fas fa-balance-scale text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Penimbangan</h5>
                            <p class="text-xs text-gray-600">Proses penimbangan akurat</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.4s">
                                <i class="fas fa-keyboard text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Input Data</h5>
                            <p class="text-xs text-gray-600">Input data ke sistem</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.6s">
                                <i class="fas fa-calculator text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Perhitungan Otomatis</h5>
                            <p class="text-xs text-gray-600">Perhitungan otomatis</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.8s">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Laporan Real-time</h5>
                            <p class="text-xs text-gray-600">Laporan langsung tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-20 bg-gradient-to-b from-white to-green-50">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-12 reveal">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4 text-gray-600">Frequently Asked Questions</h3>
                    <p class="text-gray-600 text-lg">Pertanyaan yang sering diajukan tentang <span class="text-green-700">SisaKu</span></p>
                </div>

                <div class="space-y-4" data-aos="fade-up">
                    <div class="faq-item bg-white rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-lg text-gray-800">Apa itu  <span class="text-green-600">SisaKu?</span></h4>
                            <i class="fas fa-chevron-down faq-icon text-green-600"></i>
                        </div>
                        <div class="faq-content mt-4">
                            <p class="text-gray-600">SisaKu adalah platform digital yang membantu Karang Taruna dan Pemerintah Desa dalam mengelola bank sampah secara efisien, mencatat transaksi, mengelola kas, dan mengukur dampak lingkungan secara transparan.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-lg text-gray-800">Siapa yang bisa menggunakan <span class="text-green-600">SisaKu?</span></h4>
                            <i class="fas fa-chevron-down faq-icon text-green-600"></i>
                        </div>
                        <div class="faq-content mt-4">
                            <p class="text-gray-600">SisaKu dirancang untuk dua role utama: Karang Taruna (sebagai pengelola bank sampah) dan Pemerintah Desa (sebagai supervisor dan pembuat kebijakan). Setiap role memiliki dashboard dan fitur yang disesuaikan dengan kebutuhan mereka.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="py-24 bg-gradient-to-br from-green-50 via-white to-emerald-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">Hubungi Kami</h3>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">Untuk pertanyaan atau informasi lebih lanjut, silakan hubungi kami melalui kontak di bawah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    <div class="bg-white rounded-3xl p-10 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-green-100" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-20 h-20 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-map-marker-alt text-white text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-4 text-gray-800">Lokasi</h4>
                        <p class="text-gray-600 text-base leading-relaxed">Jl. Telekomunikasi, Bandung, Indonesia</p>
                    </div>

                    <div class="bg-white rounded-3xl p-10 text-center reveal hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-green-100">
                        <div class="w-20 h-20 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-phone text-white text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-4 text-gray-800">Telepon</h4>
                        <p class="text-gray-600 text-base leading-relaxed">+62 812-3456-7890</p>
                    </div>

                    <div class="bg-white rounded-3xl p-10 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-green-100" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-20 h-20 bg-green-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-envelope text-white text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-4 text-gray-800">Email</h4>
                        <p class="text-gray-600 text-base leading-relaxed">info@<span class="text-green-600">SisaKu</span>.com</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-green-700">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 text-center text-white shadow-2xl reveal">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">Siap Mengelola Bank Sampah Secara Digital?</h3>
                    <p class="text-lg text-green-50 mb-8 max-w-9xl mx-auto">Bergabung dengan komunitas yang sudah menggunakan SisaKu</span> untuk transformasi pengelolaan sampah yang lebih modern dan berkelanjutan.</p>
                    <div class="flex flex-wrap justify-center gap-4">

                        <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-green-600 transition-all">Masuk</a>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.footer')

        <script>
            function toggleFaq(element) {
                const allFaqs = document.querySelectorAll('.faq-item');
                allFaqs.forEach(faq => {
                    if (faq !== element && faq.classList.contains('active')) {
                        faq.classList.remove('active');
                    }
                });
                element.classList.toggle('active');
            }

            // Typewriter Effect for Hero Title
            function typeWriterSequential(elements, texts, speed = 45, colors = []) {
                let elementIndex = 0;
                
                function typeNextElement() {
                    if (elementIndex >= elements.length) return;
                    
                    const element = elements[elementIndex];
                    const text = texts[elementIndex];
                    const color = colors[elementIndex] || 'white';
                    let charIndex = 0;
                    element.innerHTML = '';
                    
                    function type() {
                        if (charIndex < text.length) {
                            const char = text.charAt(charIndex);
                            element.innerHTML += `<span style="font-weight: bold; color: ${color};">${char}</span>`;
                            charIndex++;
                            setTimeout(type, speed);
                        } else {
                            elementIndex++;
                            setTimeout(typeNextElement, 200);
                        }
                    }
                    
                    type();
                }
                
                typeNextElement();
            }

            document.addEventListener('DOMContentLoaded', () => {
                const line1 = document.getElementById('typewriterLine1');
                const line2 = document.getElementById('typewriterLine2');
                
                if (line1 && line2) {
                    setTimeout(() => {
                        typeWriterSequential([line1, line2], ['Smart Waste Management', 'Platform'], 45, ['white', '#0f9f44ff']);
                    }, 300);
                }
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // Ultra-responsive font sizing for stat cards - automatically shrinks font without breaking layout or covering icons
            function makeNumbersResponsive() {
                const responsiveElements = document.querySelectorAll('.responsive-number');

                responsiveElements.forEach(element => {
                    const card = element.closest('.glass-dark');
                    if (!card) return;

                    // Find the icon element in the same card (more robust selector)
                    const iconElement = card.querySelector('.w-12.h-12, .w-10, .w-11, .w-12');
                    const iconWidth = iconElement ? iconElement.offsetWidth + 20 : 68; // Icon width + larger gap for safety

                    const text = element.getAttribute('data-value') || element.textContent.trim();
                    const cardWidth = card.offsetWidth;
                    const padding = 40; // Increased padding for better spacing
                    const availableWidth = cardWidth - padding - iconWidth; // More conservative space calculation

                    // Reset font size first to get accurate measurement
                    element.style.fontSize = '';

                    // Create test element to measure text width with current styles
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

                    // Calculate scale factor - more aggressive shrinking for very long text
                    const scale = Math.min(1, availableWidth / textWidth);
                    const finalScale = Math.max(0.25, scale); // Lower minimum (25%) for very long numbers

                    // Apply the scaling with smooth transition
                    const originalSize = parseFloat(window.getComputedStyle(element).fontSize);
                    const newSize = originalSize * finalScale;

                    // Ensure minimum readable size
                    const minSize = 12; // Minimum 12px for readability
                    const finalSize = Math.max(minSize, newSize);

                    element.style.fontSize = `${finalSize}px`;

                    // Add subtle letter spacing for very small text to improve readability
                    if (finalScale < 0.5) {
                        element.style.letterSpacing = '0.5px';
                    } else {
                        element.style.letterSpacing = '';
                    }
                });
            }

            // Make numbers responsive on load and resize
            document.addEventListener('DOMContentLoaded', function() {
                makeNumbersResponsive();
                window.addEventListener('resize', makeNumbersResponsive);
            });
        </script>

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
    <script>
        // Ultra-Smooth GSAP ScrollTrigger - Repeating animations on every scroll down
        document.addEventListener('DOMContentLoaded', function() {
            gsap.registerPlugin(ScrollTrigger);

            // Hero section ultra-smooth fade in
            gsap.from("#beranda", {
                opacity: 0,
                y: 30,
                duration: 1.5,
                ease: "power3.out"
            });

            // Stat cards ultra-smooth reveal - repeats every scroll down, stays visible when scrolling up
            gsap.utils.toArray('.glass-dark').forEach((card, i) => {
                gsap.from(card, {
                    y: 35,
                    opacity: 0,
                    duration: 1.0,
                    ease: "power3.out",
                    delay: i * 0.08,
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "restart none none none"
                    }
                });
            });

            // Feature cards optimized reveal - reduced stagger for better performance
            gsap.utils.toArray('.card-hover').forEach((card, i) => {
                gsap.from(card, {
                    y: 30,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power2.out",
                    delay: (i % 3) * 0.1,
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "play none none reverse"
                    }
                });
            });

            // Section headers optimized reveal - reduced duration for better performance
            gsap.utils.toArray('section h3, section h2').forEach((header) => {
                gsap.from(header, {
                    y: 20,
                    opacity: 0,
                    duration: 0.9,
                    ease: "power2.out",
                    scrollTrigger: {
                        trigger: header,
                        start: "top 80%",
                        toggleActions: "play none none reverse"
                    }
                });
            });

            // Contact cards ultra-smooth animation - repeats every scroll down, stays visible when scrolling up
            gsap.utils.toArray('.bg-white.rounded-3xl.p-10').forEach((card, i) => {
                gsap.from(card, {
                    y: 35,
                    opacity: 0,
                    duration: 1.1,
                    ease: "power3.out",
                    delay: i * 0.2,
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "restart none none none"
                    }
                });
            });

            // FAQ items ultra-smooth slide - repeats every scroll down, stays visible when scrolling up
            gsap.utils.toArray('.faq-item').forEach((item, i) => {
                gsap.from(item, {
                    y: 25,
                    opacity: 0,
                    duration: 0.9,
                    ease: "power3.out",
                    delay: i * 0.08,
                    scrollTrigger: {
                        trigger: item,
                        start: "top 88%",
                        toggleActions: "restart none none none"
                    }
                });
            });

            // CTA section ultra-smooth reveal - repeats every scroll down, stays visible when scrolling up
            gsap.from(".bg-white\\/10", {
                y: 45,
                opacity: 0,
                duration: 1.4,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: ".bg-white\\/10",
                    start: "top 80%",
                    toggleActions: "restart none none none"
                }
            });

            // Metric cards optimized scale - reduced complexity for better performance
            gsap.utils.toArray('.bg-green-100, .bg-emerald-100, .bg-teal-100, .bg-green-200').forEach((metric, i) => {
                gsap.from(metric, {
                    y: 15,
                    opacity: 0,
                    duration: 0.7,
                    ease: "power2.out",
                    delay: i * 0.08,
                    scrollTrigger: {
                        trigger: metric,
                        start: "top 85%",
                        toggleActions: "play none none reverse"
                    }
                });
            });

            // Workflow steps ultra-smooth reveal - repeats every scroll down, stays visible when scrolling up
            gsap.utils.toArray('.float-element').forEach((step, i) => {
                gsap.from(step, {
                    y: 30,
                    opacity: 0,
                    duration: 1.1,
                    ease: "power3.out",
                    delay: i * 0.2,
                    scrollTrigger: {
                        trigger: step,
                        start: "top 82%",
                        toggleActions: "restart none none none"
                    }
                });
            });
        });
    </script>

    <!-- Custom JS -->
    @vite(['resources/js/app.js'])

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
    </body>
    </html>
