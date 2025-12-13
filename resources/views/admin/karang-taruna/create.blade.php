@extends('admin.layouts.app')

@section('title', 'Tambah Karang Taruna - SisaKu')

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-4 sm:mb-6 md:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6 flex items-center gap-2 sm:gap-4">
        <a href="{{ route('admin.karang-taruna.index') }}" class="p-2 sm:p-3 hover:bg-gray-100 rounded-lg sm:rounded-2xl transition-colors flex-shrink-0">
            <i class="fas fa-arrow-left text-gray-600 text-sm sm:text-base"></i>
        </a>
        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl md:text-4xl font-bold text-gray-900 truncate">Tambah Karang Taruna</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium truncate">Form pendaftaran Karang Taruna baru</p>
        </div>
    </div>
</div>

<!-- Error Messages -->
@if($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 mb-4 sm:mb-6 rounded-lg sm:rounded-xl animate-scale-in">
    <div class="flex items-start gap-2 sm:gap-3">
        <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <div class="flex-1 min-w-0">
            <p class="text-red-800 font-semibold mb-2 text-sm sm:text-base">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside text-red-700 text-xs sm:text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.karang-taruna.store') }}" method="POST" id="karangTarunaForm" class="space-y-4 sm:space-y-5 md:space-y-6" autocomplete="off">
    @csrf

    <!-- User Account Section -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern animate-scale-in">
        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-soft flex-shrink-0">
                <i class="fas fa-user text-green-600 text-xs sm:text-sm"></i>
            </div>
            <div class="min-w-0">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Akun Pengguna</h3>
                <p class="text-xs text-gray-500 mt-0.5">Data login untuk Karang Taruna</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-5">
            <!-- Username -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    value="{{ old('username') }}"
                    placeholder="Contoh: kt_rw01"
                    autocomplete="off"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('username') border-red-500 @enderror"
                    required
                >
                <div class="text-red-500 text-xs mt-1 hidden" id="usernameError">Username wajib diisi</div>
                @error('username')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@gmail.com"
                    autocomplete="off"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('email') border-red-500 @enderror"
                    required
                >
                @error('email')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password and Confirm Password in same row -->
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-5">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Minimal 6 karakter"
                                autocomplete="new-password"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('password') border-red-500 @enderror"
                                required
                            >
                            <button
                                type="button"
                                onclick="togglePassword('password')"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                        </div>
                        <div class="text-red-500 text-xs mt-1 hidden" id="passwordError">Password wajib diisi (minimal 6 karakter)</div>
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                placeholder="Ketik ulang password"
                                autocomplete="new-password"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm"
                                required
                            >
                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password_confirmation-icon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Karang Taruna Data Section -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-soft flex-shrink-0">
                <i class="fas fa-building text-green-600 text-xs sm:text-sm"></i>
            </div>
            <div class="min-w-0">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Data Karang Taruna</h3>
                <p class="text-xs text-gray-500 mt-0.5">Informasi unit bank sampah</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-5">
            <!-- Nama Karang Taruna -->
            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Nama Karang Taruna <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_karang_taruna"
                    id="namaKarangTaruna"
                    value="{{ old('nama_karang_taruna') }}"
                    placeholder="Contoh: Karang Taruna Bojongsoang RW 01"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('nama_karang_taruna') border-red-500 @enderror"
                    required
                >
                <div class="text-red-500 text-xs mt-1 hidden" id="namaKarangTarunaError">Nama Karang Taruna wajib diisi</div>
                @error('nama_karang_taruna')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('nama_lengkap') border-red-500 @enderror"
                >
                @error('nama_lengkap')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telp -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    No. Telepon
                </label>
                <input
                    type="text"
                    name="no_telp"
                    value="{{ old('no_telp') }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('no_telp') border-red-500 @enderror"
                >
                @error('no_telp')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- RW -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    RW <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="rw" 
                    value="{{ old('rw') }}"
                    placeholder="Contoh: 01"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('rw') border-red-500 @enderror"
                    required
                >
                @error('rw')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2 sm:gap-4">
                    <label class="flex-1 cursor-pointer">
                        <input
                            type="radio"
                            name="status"
                            value="aktif"
                            id="status_aktif"
                            {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }}
                            class="hidden peer"
                            required
                        >
                        <div class="p-4 border-2 rounded-xl transition-all peer-checked:border-green-500 peer-checked:bg-green-50 border-gray-200 hover:border-gray-300">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full border-2 peer-checked:border-green-500 border-gray-300 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-green-500 hidden peer-checked:block"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Aktif</p>
                                    <p class="text-xs text-gray-500">Dapat login</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input
                            type="radio"
                            name="status"
                            value="nonaktif"
                            id="status_nonaktif"
                            {{ old('status') == 'nonaktif' ? 'checked' : '' }}
                            class="hidden peer"
                        >
                        <div class="p-4 border-2 rounded-xl transition-all peer-checked:border-red-500 peer-checked:bg-red-50 border-gray-200 hover:border-gray-300">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full border-2 peer-checked:border-red-500 border-gray-300 flex items-center justify-center">
                                    <div class="w-3 h-3 rounded-full bg-red-500 hidden peer-checked:block"></div>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Nonaktif</p>
                                    <p class="text-xs text-gray-500">Tidak dapat login</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="text-red-500 text-xs mt-1 hidden" id="statusError">Status wajib dipilih</div>
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex gap-2 sm:gap-4 animate-fade-in-up" style="animation-delay: 0.2s;">
        <a href="{{ route('admin.karang-taruna.index') }}" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 md:py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg sm:rounded-xl md:rounded-2xl font-semibold text-center transition-all shadow-soft transform hover:scale-105 text-xs sm:text-sm md:text-base">
            <i class="fas fa-times hidden sm:inline mr-2"></i>
            <span class="sm:hidden">Batal</span>
            <span class="hidden sm:inline">Batal</span>
        </a>
        <button type="submit" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 md:py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-lg text-white rounded-lg sm:rounded-xl md:rounded-2xl font-semibold transition-all shadow-modern transform hover:scale-105 text-xs sm:text-sm md:text-base">
            <i class="fas fa-check-circle hidden sm:inline mr-2"></i>
            <span class="sm:hidden">Simpan</span>
            <span class="hidden sm:inline">Simpan Data</span>
        </button>
    </div>
</form>

</div>

@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

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

// Indonesian form validation
document.getElementById('karangTarunaForm').addEventListener('submit', function(e) {
    let isValid = true;

    // Reset error messages
    document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));

    // Validate username
    const username = document.getElementById('username').value.trim();
    if (!username) {
        document.getElementById('usernameError').classList.remove('hidden');
        isValid = false;
    }

    // Validate password
    const password = document.getElementById('password').value.trim();
    if (!password || password.length < 6) {
        document.getElementById('passwordError').classList.remove('hidden');
        isValid = false;
    }

    // Validate nama karang taruna
    const namaKarangTaruna = document.getElementById('namaKarangTaruna').value.trim();
    if (!namaKarangTaruna) {
        document.getElementById('namaKarangTarunaError').classList.remove('hidden');
        isValid = false;
    }

    // Validate status
    const status = document.querySelector('input[name="status"]:checked');
    if (!status) {
        document.getElementById('statusError').classList.remove('hidden');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
        // Show notification
        showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
        return false;
    }
});

// Real-time validation
document.getElementById('username').addEventListener('input', function() {
    if (this.value.trim()) {
        document.getElementById('usernameError').classList.add('hidden');
    }
});

document.getElementById('password').addEventListener('input', function() {
    if (this.value.trim() && this.value.length >= 6) {
        document.getElementById('passwordError').classList.add('hidden');
    }
});

document.getElementById('namaKarangTaruna').addEventListener('input', function() {
    if (this.value.trim()) {
        document.getElementById('namaKarangTarunaError').classList.add('hidden');
    }
});

// Update radio button visual state
document.addEventListener('DOMContentLoaded', function() {
    const radioButtons = document.querySelectorAll('input[type="radio"][name="status"]');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Remove checked styling from all
            document.querySelectorAll('input[type="radio"][name="status"]').forEach(r => {
                const label = r.closest('label');
                const dot = label.querySelector('.w-3.h-3');

                if (r.checked) {
                    if (r.value === 'aktif') {
                        label.querySelector('.p-4').classList.add('border-green-500', 'bg-green-50');
                        label.querySelector('.p-4').classList.remove('border-gray-200');
                        label.querySelector('.w-5.h-5').classList.add('border-green-500');
                    } else {
                        label.querySelector('.p-4').classList.add('border-red-500', 'bg-red-50');
                        label.querySelector('.p-4').classList.remove('border-gray-200');
                        label.querySelector('.w-5.h-5').classList.add('border-red-500');
                    }
                    dot.classList.remove('hidden');
                    // Hide status error when selected
                    document.getElementById('statusError').classList.add('hidden');
                } else {
                    label.querySelector('.p-4').classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
                    label.querySelector('.p-4').classList.add('border-gray-200');
                    label.querySelector('.w-5.h-5').classList.remove('border-green-500', 'border-red-500');
                    dot.classList.add('hidden');
                }
            });
        });
    });

    // Set initial state for the default checked radio
    const checkedRadio = document.querySelector('input[type="radio"][name="status"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
