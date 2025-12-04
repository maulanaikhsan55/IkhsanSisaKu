@extends('admin.layouts.app')

@section('title', 'Riwayat Reset Password - SisaKu')

@section('content')

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-start gap-3 sm:gap-4">
        <a href="{{ route('admin.password-reset.index') }}" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
            <i class="fas fa-arrow-left text-gray-700"></i>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-1 sm:mb-2">Riwayat Reset Password</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Daftar password yang telah direset oleh admin</p>
        </div>
    </div>
</div>

<!-- Password Reset History Table -->
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
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Password Sementara</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Tanggal Direset</th>
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
                                    <span class="text-gray-900 font-medium truncate">{{ $request->user?->name ?? 'User Dihapus' }}</span>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700">{{ $request->user?->email ?? 'N/A' }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm">
                                <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg w-fit">
                                    <code class="text-gray-700 font-mono text-xs">
                                        {{ $request->notes }}
                                    </code>
                                    <button type="button" class="copy-btn text-gray-400 hover:text-gray-600 transition-colors" data-text="{{ $request->notes }}" title="Salin password">
                                        <i class="fas fa-copy text-xs"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600">
                                <div>
                                    <p class="font-medium">{{ $request->updated_at->format('d M Y') }}</p>
                                    <p class="text-gray-500 text-xs">{{ $request->updated_at->format('H:i') }}</p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fas fa-inbox text-gray-300 text-3xl sm:text-4xl"></i>
                                    <p class="text-gray-500 font-medium text-sm sm:text-base">Tidak ada riwayat reset password</p>
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
                <p class="text-gray-500 font-medium text-sm sm:text-base">Tidak ada riwayat reset password</p>
            </div>
        </div>
    @endif
</div>

<script>
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.dataset.text;
            navigator.clipboard.writeText(text).then(() => {
                const icon = this.querySelector('i');
                const originalClass = icon.className;
                icon.className = 'fas fa-check text-green-600';
                setTimeout(() => {
                    icon.className = originalClass;
                }, 2000);
            });
        });
    });

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

@endsection
