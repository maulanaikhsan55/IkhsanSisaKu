<footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-8 sm:py-12" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto px-3 sm:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 lg:gap-10 mb-6 sm:mb-8">
            <!-- Logo & Description -->
            <div class="sm:col-span-2 lg:col-span-2">
                <div class="flex items-center gap-2 mb-3 sm:mb-4">
                    <div class="w-9 sm:w-10 h-9 sm:h-10 bg-white rounded-lg sm:rounded-xl shadow-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-5 sm:w-6 h-5 sm:h-6">
                    </div>
                    <span class="font-bold text-green-400 text-lg sm:text-xl">SisaKu</span>
                </div>
                <p class="text-gray-400 text-xs sm:text-sm max-w-md mb-4 sm:mb-6 leading-relaxed">Platform digital untuk mengelola bank sampah secara modern, transparan, dan efisien.</p>
                <div class="flex gap-2">
                    <a href="#" class="w-8 sm:w-9 h-8 sm:h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-xs sm:text-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-8 sm:w-9 h-8 sm:h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-xs sm:text-sm">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-8 sm:w-9 h-8 sm:h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-xs sm:text-sm">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-8 sm:w-9 h-8 sm:h-9 bg-gray-700 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-xs sm:text-sm">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div>
                <h4 class="font-semibold text-sm sm:text-base mb-3 text-green-400">Navigasi</h4>
                <ul class="space-y-1.5 sm:space-y-2 text-gray-400 text-xs sm:text-sm">
                    <li><a href="{{ route('welcome') }}" class="hover:text-green-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('welcome') }}#fitur" class="hover:text-green-400 transition-colors">Fitur</a></li>
                    <li><a href="{{ route('welcome') }}#tentang" class="hover:text-green-400 transition-colors">Tentang</a></li>
                    <li><a href="{{ route('welcome') }}#faq" class="hover:text-green-400 transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Account -->
            <div>
                <h4 class="font-semibold text-sm sm:text-base mb-3 text-green-400">Akun</h4>
                <ul class="space-y-1.5 sm:space-y-2 text-gray-400 text-xs sm:text-sm">
                    <li><a href="{{ route('login') }}" class="hover:text-green-400 transition-colors">Masuk</a></li>
                    <li><a href="#" class="hover:text-green-400 transition-colors">Bantuan</a></li>
                    <li><a href="#" class="hover:text-green-400 transition-colors">Kontak</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-4 sm:pt-6">
            <p class="text-gray-500 text-xs sm:text-sm text-center leading-relaxed">&copy; 2025 SisaKu. Made with <span class="text-red-500">♥</span> for a better environment.</p>
        </div>
    </div>
</footer>
