@extends('admin.layouts.app')

@section('title', 'Permintaan Reset Password - SisaKu')

@section('content')

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-1 sm:mb-2">Permintaan Reset Password</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola permintaan reset password dari pengguna</p>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 mb-6 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm">
    <div class="flex items-center gap-2">
        <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <div>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 mb-6 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm">
    <div class="flex items-center gap-2">
        <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <p class="text-red-800 font-medium">{{ session('error') }}</p>
    </div>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
    <div class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start gap-3">
            <div>
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-2">Menunggu Aksi</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $pendingCount }}</h3>
                <p class="text-xs text-yellow-600 mt-2 font-medium">Permintaan</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-100 to-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-yellow-600 text-lg sm:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
        <div class="flex justify-between items-start gap-3">
            <div>
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-2">Sudah Diproses</p>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $resolvedCount }}</h3>
                <p class="text-xs text-green-600 mt-2 font-medium">Selesai</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-lg sm:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Password Reset Requests Table -->
<div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden">
    <!-- Search Section -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <div class="w-full sm:w-64">
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition">
        </div>
    </div>

    @if($requests->count() > 0)
        <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">No.</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Nama Pengguna</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Tanggal Permintaan</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="resetTableBody" class="divide-y divide-gray-200">
                    @forelse($requests as $index => $request)
                        <tr class="hover:bg-green-50 transition-all duration-200">
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700">{{ ($requests->currentPage() - 1) * $requests->perPage() + $index + 1 }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user text-green-600 text-xs sm:text-sm"></i>
                                    </div>
                                    <span class="text-gray-900 font-medium truncate">{{ $request->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700">{{ $request->user->email }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600">
                                <div>
                                    <p class="font-medium">{{ $request->created_at->format('d M Y') }}</p>
                                    <p class="text-gray-500 text-xs">{{ $request->created_at->format('H:i') }}</p>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                <form action="{{ route('admin.password-reset.reset', $request->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg sm:rounded-xl font-semibold transition-all text-xs sm:text-sm" onclick="return confirm('Reset password user {{ $request->user->name }}?')">
                                        <i class="fas fa-key text-sm"></i>
                                        <span class="hidden sm:inline">Reset Password</span>
                                        <span class="sm:hidden">Reset</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-inbox text-gray-300 text-3xl sm:text-4xl"></i>
                                    <p class="text-gray-500 font-medium text-sm sm:text-base">Tidak ada permintaan reset password</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($requests->hasPages())
            <div class="px-3 sm:px-6 py-4 border-t border-gray-200 flex justify-center">
                {{ $requests->links('pagination.custom') }}
            </div>
        @endif
    @else
        <div class="p-6 sm:p-8 md:p-12 text-center">
            <div class="flex flex-col items-center justify-center gap-3">
                <i class="fas fa-inbox text-gray-300 text-4xl sm:text-5xl"></i>
                <p class="text-gray-500 font-medium text-sm sm:text-base">Tidak ada permintaan reset password</p>
                <p class="text-gray-400 text-xs sm:text-sm">Semua pengguna dapat mengelola password mereka sendiri</p>
            </div>
        </div>
    @endif
</div>

<!-- History Section -->
<div class="mt-6 sm:mt-8">
    <div class="mb-3 sm:mb-4">
        <a href="{{ route('admin.password-reset.history') }}" class="inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg sm:rounded-2xl font-semibold transition-all text-sm sm:text-base">
            <i class="fas fa-history"></i> <span class="hidden sm:inline">Lihat Riwayat Reset Password</span><span class="sm:hidden">Riwayat</span>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#resetTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endpush
