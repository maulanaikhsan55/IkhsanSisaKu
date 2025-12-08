<footer class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-12" style="font-family: 'Poppins', sans-serif;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-lg flex items-center justify-center">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-6 h-6">
                    </div>
                <span class="font-bold text-green-700 text-xl">SisaKu</span>
                </div>
                <p class="text-gray-400 text-sm max-w-md mb-6">Platform digital untuk mengelola bank sampah secara modern, transparan, dan efisien. Bersama kita ciptakan lingkungan yang lebih bersih dan berkelanjutan.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-sm">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-sm">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors text-sm">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="font-semibold text-base mb-4 text-green-400">Navigasi</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('welcome') }}" class="hover:text-green-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('welcome') }}#fitur" class="hover:text-green-400 transition-colors">Fitur</a></li>
                    <li><a href="{{ route('welcome') }}#tentang" class="hover:text-green-400 transition-colors">Tentang</a></li>
                    <li><a href="{{ route('welcome') }}#faq" class="hover:text-green-400 transition-colors">FAQ</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-base mb-4 text-green-400">Akun</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('login') }}" class="hover:text-green-400 transition-colors">Masuk</a></li>

                    <li><a href="#" class="hover:text-green-400 transition-colors">Bantuan</a></li>
                    <li><a href="#" class="hover:text-green-400 transition-colors">Kontak</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-6">
            <p class="text-gray-500 text-sm text-center">&copy; 2025 SisakU. All rights reserved. Made with <span class="text-red-500">♥</span> for a better environment.</p>
        </div>
    </div>
</footer>
