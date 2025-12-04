<nav class="bg-white border-b border-gray-200 fixed w-full z-50 top-0 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Logo SisaKu" class="w-8 h-8">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-green-700">SisaKu</h1>
                    <p class="text-xs text-gray-500">Sistem Bank Sampah Digital</p>
                </div>
            </div>

            <!-- User Info & Logout -->
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
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
