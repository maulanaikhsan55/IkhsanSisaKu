<nav class="bg-white border-b border-gray-200 fixed w-full z-50 top-0 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-1.5">
                <div class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 bg-white rounded-lg sm:rounded-xl shadow-md flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-4 sm:w-5 md:w-6 h-4 sm:h-5 md:h-6">
                </div>
                <div class="min-w-0">
                    <h1 class="text-sm sm:text-base md:text-lg font-bold text-green-700 truncate">SisaKu</h1>
                    <p class="text-xs text-gray-400 font-normal mt-0">Sistem Bank Sampah Digital</p>
                </div>
            </div>

            <!-- User Info & Logout -->
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->karangTaruna ? auth()->user()->karangTaruna->nama_lengkap : auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->role->nama_role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition shadow">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
