<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
        <title>SisaKu - Sistem Bank Sampah Digital</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
        <style>
            * { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
            body { overflow-x: hidden; }

            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(16, 185, 129, 0.15);
            }

            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease;
            }
            .reveal.show {
                opacity: 1;
                transform: translateY(0);
            }

            .stagger-1 { transition-delay: 0.1s; }
            .stagger-2 { transition-delay: 0.2s; }
            .stagger-3 { transition-delay: 0.3s; }
            .stagger-4 { transition-delay: 0.4s; }
            .stagger-5 { transition-delay: 0.5s; }

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
                animation: pulse-glow 2s ease-in-out infinite;
            }
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 15px rgba(34, 197, 94, 0.3); }
                50% { box-shadow: 0 0 30px rgba(34, 197, 94, 0.5); }
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
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .hover-lift:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }
        </style>
    </head>
    <body class="bg-white text-gray-800">

        <nav class="w-full fixed top-0 left-0 right-0 z-50 flex items-center justify-between md:justify-center pt-2 sm:pt-4 px-3 sm:px-4 md:px-0">
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-bars text-gray-700 text-lg"></i>
            </button>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-4 lg:gap-8 bg-white shadow-lg rounded-full px-6 lg:px-10 py-2 sm:py-3 border border-gray-200">
                <div class="flex items-center gap-2">
                    <div class="w-10 lg:w-12 h-10 lg:h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-6 lg:w-8 h-6 lg:h-8">
                    </div>
                    <span class="font-bold text-green-700 text-lg lg:text-xl">SisaKu</span>
                </div>
                <a href="#beranda" class="text-xs lg:text-sm text-gray-700 hover:text-green-600 transition font-medium">Beranda</a>
                <a href="#fitur" class="text-xs lg:text-sm text-gray-700 hover:text-green-600 transition font-medium">Fitur</a>
                <a href="#tentang" class="text-xs lg:text-sm text-gray-700 hover:text-green-600 transition font-medium">Tentang</a>
                <a href="#faq" class="text-xs lg:text-sm text-gray-700 hover:text-green-600 transition font-medium">FAQ</a>
                <a href="#kontak" class="text-xs lg:text-sm text-gray-700 hover:text-green-600 transition font-medium">Kontak</a>
                <a href="{{ route('login') }}" class="px-4 lg:px-5 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs lg:text-sm rounded-full shadow transition font-medium">Mulai Sekarang</a>
            </div>

            <!-- Mobile Logo (centered) -->
            <div class="md:hidden flex items-center gap-1.5 flex-1 justify-center">
                <div class="w-8 h-8 bg-white rounded-xl shadow-md flex items-center justify-center">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-5 h-5">
                </div>
                <span class="font-bold text-green-700 text-sm">SisaKu</span>
            </div>

            <!-- Mobile Menu Close Button -->
            <button id="mobileMenuCloseBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 hover:bg-gray-100 rounded-lg hidden transition-colors">
                <i class="fas fa-times text-gray-700 text-lg"></i>
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
        </script>

        <section id="beranda" class="relative w-full h-80 sm:h-96 md:h-[480px] bg-cover bg-center max-w-6xl mx-auto mt-24 sm:mt-28 rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden parallax-bg reveal" style="background-image: url('{{ asset('storage/images/sampah.jpg') }}');">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-green-500 stat-card hover-lift reveal stagger-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center pulse-glow">
                            <i class="fas fa-trash-alt text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Sampah</p>
                            <p class="text-2xl font-bold text-gray-800">1,245 kg</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-emerald-500 stat-card hover-lift reveal stagger-2">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center pulse-glow">
                            <i class="fas fa-wallet text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kas Masuk</p>
                            <p class="text-2xl font-bold text-gray-800">Rp 4,2 JT</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-green-600 stat-card hover-lift reveal stagger-3">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center pulse-glow">
                            <i class="fas fa-users text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Warga</p>
                            <p class="text-2xl font-bold text-gray-800">320+</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-teal-500 stat-card hover-lift reveal stagger-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center pulse-glow">
                            <i class="fas fa-leaf text-teal-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CO₂e Dikurangi</p>
                            <p class="text-2xl font-bold text-gray-800">2.5 Ton</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-16 bg-gradient-to-b from-white to-green-50">
            <div class="max-w-5xl mx-auto px-6 text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-3 reveal">
                    Why Choose <span class="text-green-600">SisaKu?</span>
                </h2>
                <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto reveal">
                    Kami hadir untuk menjawab satu tantangan: bagaimana mengubah sisa menjadi nilai. SisaKu memadukan teknologi, desain, dan prinsip circular economy untuk menciptakan produk yang elegant tanpa mengganggu jejak besar pada bumi.
                </p>
            </div>
        </section>

        <section id="fitur" class="py-20 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16 reveal">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4 text-green-700">Everything You Need</h3>
                    <p class="text-gray-600 text-lg md:text-xl max-w-2xl mx-auto">Powerful features designed to revolutionize waste management in your community.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-1 glass-morphism">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-database text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Manage Waste Bank</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Sistem pencatatan dan manajemen bank sampah yang mudah dan terintegrasi dengan fitur analitik real-time.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-2 glass-morphism">
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-chart-line text-emerald-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Manage User Data</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Kelola data warga dan nasabah dengan aman. Lacak riwayat transaksi dan kontribusi setiap anggota.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-3 glass-morphism">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Manage Villagers</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Dashboard khusus untuk mengelola data warga, tracking kontribusi, dan laporan dampak lingkungan.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-4 glass-morphism">
                        <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-receipt text-teal-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Record Waste Transaction</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Catat setiap transaksi sampah secara detail. Lacak berat, jenis, dan nilai ekonomi dari setiap transaksi.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-5 glass-morphism">
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-coins text-emerald-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Environmental Fees</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Kelola iuran lingkungan dan retribusi sampah dengan transparan. Laporan otomatis untuk akuntabilitas.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-1 glass-morphism">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-file-invoice text-green-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Financial Reporting</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Generate laporan keuangan otomatis. Visualisasi arus kas yang mudah dipahami untuk transparansi maksimal.</p>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 card-hover reveal stagger-2 glass-morphism">
                        <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-chart-pie text-emerald-600 text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3 text-gray-800">Environmental Impact Reporting</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Ukur dampak nyata program bank sampah terhadap lingkungan. Dashboard CO₂e, volume waste, dan kontribusi berkelanjutan.</p>
                    </div>

                    <div class="bg-green-600 p-8 rounded-3xl shadow-xl card-hover reveal stagger-3 text-white glass-morphism">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mb-6 pulse-glow">
                            <i class="fas fa-robot text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-xl mb-3">AI-Powered Assistant</h4>
                        <p class="text-green-50 text-sm leading-relaxed">Asisten cerdas yang membantu analisis data, memberikan insight, dan rekomendasi untuk optimasi pengelolaan sampah.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="py-16 bg-gradient-to-br from-green-50 to-emerald-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="reveal">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4">The Key Metrics That Describe Our Impact</h3>
                        <p class="text-gray-600 text-base md:text-lg mb-6">Jelajahi data yang menunjukkan bagaimana SisaKu meningkatkan efisiensi pengelolaan sampah anorganik dan menciptakan transparansi kas di tingkat komunitas Anda.</p>
                                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-7 py-3 rounded-full font-semibold text-sm shadow-lg shadow-green-500/30 hover:shadow-xl hover:scale-105 transition-all">
                            Mulai Sekarang
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4 reveal">
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
                <div class="text-center mb-10 reveal">
                    <h3 class="text-2xl md:text-3xl font-bold mb-3">Integrated Waste Recording & Environmental Impact System</h3>
                    <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">A comprehensive workflow showing how waste is processed from collection to environmental impact reporting in Kota Bojongsari.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-md p-6 md:p-10 reveal border border-green-100">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md float-element">
                                <i class="fas fa-hand-holding text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Villagers Deliver Waste</h5>
                            <p class="text-xs text-gray-600">Warga menyerahkan sampah anorganik</p>
                        </div>
                        
                        <div class="text-center">
            <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.2s">
                                <i class="fas fa-balance-scale text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Weighing</h5>
                            <p class="text-xs text-gray-600">Proses penimbangan akurat</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.4s">
                                <i class="fas fa-keyboard text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Data Entry</h5>
                            <p class="text-xs text-gray-600">Input data ke sistem</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-teal-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.6s">
                                <i class="fas fa-calculator text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Automatic Calculation</h5>
                            <p class="text-xs text-gray-600">Perhitungan otomatis</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md float-element" style="animation-delay: 0.8s">
                                <i class="fas fa-chart-line text-white text-lg"></i>
                            </div>
                            <h5 class="font-semibold text-gray-800 mb-0.5 text-sm">Real-time Reporting</h5>
                            <p class="text-xs text-gray-600">Laporan langsung tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-20 bg-gradient-to-b from-white to-green-50">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-12 reveal">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">Frequently Asked Questions</h3>
                    <p class="text-gray-600 text-lg">Pertanyaan yang sering diajukan tentang SisaKu</p>
                </div>

                <div class="space-y-4 reveal">
                    <div class="faq-item bg-white rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-lg text-gray-800">Apa itu SisaKu?</h4>
                            <i class="fas fa-chevron-down faq-icon text-green-600"></i>
                        </div>
                        <div class="faq-content mt-4">
                            <p class="text-gray-600">SisaKu adalah platform digital yang membantu Karang Taruna dan Pemerintah Desa dalam mengelola bank sampah secara efisien, mencatat transaksi, mengelola kas, dan mengukur dampak lingkungan secara transparan.</p>
                        </div>
                    </div>

                    <div class="faq-item bg-white rounded-2xl p-6 shadow-lg cursor-pointer" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold text-lg text-gray-800">Siapa yang bisa menggunakan SisaKu?</h4>
                            <i class="fas fa-chevron-down faq-icon text-green-600"></i>
                        </div>
                        <div class="faq-content mt-4">
                            <p class="text-gray-600">SisaKu dirancang untuk dua role utama: Karang Taruna (sebagai pengelola bank sampah) dan Pemerintah Desa (sebagai supervisor dan pembuat kebijakan). Setiap role memiliki dashboard dan fitur yang disesuaikan dengan kebutuhan mereka.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-12 reveal">
                    <h3 class="text-2xl md:text-3xl font-bold mb-3">Hubungi Kami</h3>
                    <p class="text-gray-600 text-base md:text-lg max-w-2xl mx-auto">Untuk pertanyaan atau informasi lebih lanjut, silakan hubungi kami melalui kontak di bawah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-8 text-center reveal hover:shadow-lg transition-shadow border border-green-100">
                        <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-800">Lokasi</h4>
                        <p class="text-gray-600 text-sm">Jl.telkomunikasi<br>Bandung, Indonesia</p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 text-center reveal hover:shadow-lg transition-shadow border border-emerald-100">
                        <div class="w-16 h-16 bg-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="fas fa-phone text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-800">Telepon</h4>
                        <p class="text-gray-600 text-sm">+62 812-3456-7890<br></p>
                    </div>

                    <div class="bg-white rounded-2xl p-8 text-center reveal hover:shadow-lg transition-shadow border border-teal-100">
                        <div class="w-16 h-16 bg-teal-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                            <i class="fas fa-envelope text-white text-2xl"></i>
                        </div>
                        <h4 class="font-bold text-lg mb-2 text-gray-800">Email</h4>
                        <p class="text-gray-600 text-sm">info@SisaKu.com</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-green-700">
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-12 text-center text-white shadow-2xl reveal">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">Siap Mengelola Bank Sampah Secara Digital?</h3>
                    <p class="text-lg text-green-50 mb-8 max-w-2xl mx-auto">Bergabung dengan komunitas yang sudah menggunakan SisaKu untuk transformasi pengelolaan sampah yang lebih modern dan berkelanjutan.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                    
                        <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-green-600 transition-all">Masuk</a>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.footer')

        <script>
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

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
                        typeWriterSequential([line1, line2], ['Smart Waste Management', 'Platform'], 45, ['white', '#22c55e']);
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
        </script>

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
    </body>
    </html>
