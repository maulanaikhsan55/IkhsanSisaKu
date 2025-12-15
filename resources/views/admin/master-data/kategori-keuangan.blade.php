@extends('admin.layouts.app')

@section('title', 'Kategori Keuangan - SisaKu')

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-4 sm:mb-6 md:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-1 sm:mb-2">Kategori Keuangan</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola kategori pemasukan dan pengeluaran</p>
        </div>

    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" class="mb-6"></div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6 md:mb-8">
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start gap-3">
            <div>
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kategori Masuk</p>
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $totalMasuk }}</h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Pemasukan</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-arrow-trend-up text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start gap-3">
            <div>
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kategori Keluar</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ $totalKeluar }}">{{ $totalKeluar }}</h3>
                <p class="text-xs text-red-600 mt-1 sm:mt-2 font-medium">Pengeluaran</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-red-100 to-red-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-arrow-trend-down text-red-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Kategori Keuangan Table -->
<div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern overflow-hidden border-modern animate-fade-in-up">
    <div class="p-3 sm:p-4 md:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Kategori Keuangan</h3>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
            <div class="w-full sm:w-auto">
                <input type="text" id="searchInput" placeholder="Cari kategori..." class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition">
            </div>
            <button onclick="openModal()" class="w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-modern text-xs sm:text-sm min-h-[44px]">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Kategori</span><span class="sm:hidden">Tambah</span>
            </button>
        </div>
    </div>
    <div class="border-t border-gray-200"></div>

    <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Nama Kategori</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Deskripsi</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Jenis</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody id="kategoriTableBody" class="bg-white divide-y divide-gray-200">
                @forelse($kategoriKeuangan as $kategori)
                <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">{{ $kategori->nama_kategori }}</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700">{{ $kategori->deskripsi ?? '-' }}</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold {{ $kategori->jenis === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if($kategori->jenis === 'masuk')
                                <i class="fas fa-arrow-down mr-0.5 sm:mr-1"></i> <span class="hidden sm:inline">Masuk</span><span class="sm:hidden">+</span>
                            @else
                                <i class="fas fa-arrow-up mr-0.5 sm:mr-1"></i> <span class="hidden sm:inline">Keluar</span><span class="sm:hidden">-</span>
                            @endif
                        </span>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                            <button onclick="editKategori({{ $kategori->id }}, {{ json_encode($kategori->nama_kategori) }}, {{ json_encode($kategori->deskripsi) }}, {{ json_encode($kategori->jenis) }})"
                                    class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteKategori({{ $kategori->id }}, {{ json_encode($kategori->nama_kategori) }})"
                                    class="p-1.5 sm:p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-xs sm:text-sm"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada kategori keuangan</h3>
                            <p class="text-gray-500">Belum ada kategori keuangan yang tersimpan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kategoriKeuangan->hasPages())
    <div class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 border-t border-gray-100 bg-gray-50">
        {{ $kategoriKeuangan->links('pagination.custom') }}
    </div>
    @endif
</div>

<!-- Modal Create/Edit -->
<div id="kategoriModal" class="fixed inset-0 hidden pointer-events-none z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="absolute inset-0 bg-black/30 pointer-events-auto" onclick="closeModal()"></div>
    <div class="bg-white rounded-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0 pointer-events-auto max-h-[95vh] overflow-y-auto flex flex-col relative z-10" id="modalContent">
        <div class="sticky top-0 bg-gradient-to-r from-green-500 to-emerald-600 px-6 sm:px-8 py-6 flex items-start justify-between z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-wallet text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-white" id="modalTitle">Tambah Kategori Keuangan</h3>
                    <p class="text-sm text-green-100 mt-1">Isi informasi kategori dengan lengkap</p>
                </div>
            </div>
            <button onclick="closeModal()" class="text-white/80 hover:text-white transition text-xl p-2 hover:bg-white/20 rounded-lg min-h-[44px] min-w-[44px] flex items-center justify-center flex-shrink-0">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="kategoriForm" method="POST" class="p-6 sm:p-8 space-y-8 flex-1 overflow-y-auto">
            @csrf
            <input type="hidden" id="kategoriId" name="id">

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">1</div>
                    <h4 class="text-lg font-semibold text-gray-900">Informasi Dasar</h4>
                </div>
                
                <div class="space-y-4 pl-11">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" id="namaKategori" name="nama_kategori" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm min-h-[44px]"
                               placeholder="Contoh: Penjualan Sampah, Sumbangan Warga">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-gray-500">(Opsional)</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm"
                                  placeholder="Jelaskan kategori keuangan ini secara singkat"></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">2</div>
                    <h4 class="text-lg font-semibold text-gray-900">Jenis Transaksi</h4>
                </div>
                
                <div class="pl-11 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="cursor-pointer group">
                        <input type="radio" name="jenis" value="masuk" id="tipe_masuk" required class="hidden peer">
                        <div class="p-4 border-2 rounded-lg transition-all peer-checked:border-green-500 peer-checked:bg-green-50 border-gray-200 hover:border-green-300 group-hover:shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full border-2 peer-checked:border-green-500 border-gray-300 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-green-500 hidden peer-checked:block"></div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">Pemasukan</p>
                                    <p class="text-xs text-gray-600">Dana yang masuk ke sistem</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="jenis" value="keluar" id="tipe_keluar" class="hidden peer">
                        <div class="p-4 border-2 rounded-lg transition-all peer-checked:border-red-500 peer-checked:bg-red-50 border-gray-200 hover:border-red-300 group-hover:shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-5 h-5 rounded-full border-2 peer-checked:border-red-500 border-gray-300 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-500 hidden peer-checked:block"></div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">Pengeluaran</p>
                                    <p class="text-xs text-gray-600">Dana yang keluar dari sistem</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all min-h-[44px]">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all min-h-[44px] flex items-center justify-center gap-2">
                    <i class="fas fa-check"></i><span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 hidden pointer-events-none z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/30 pointer-events-auto" onclick="closeDeleteModal()"></div>
    <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0 pointer-events-auto relative z-10" id="deleteModalContent">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-exclamation-circle text-red-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Kategori</h3>
            <p class="text-gray-600 mb-6 text-sm" id="deleteMessage">Apakah Anda yakin ingin menghapus kategori ini?</p>

            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all min-h-[44px]">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all min-h-[44px] flex items-center justify-center gap-2">
                    <i class="fas fa-trash"></i><span>Hapus</span>
                </button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modal-handlers.js') }}"></script>
    <script src="{{ asset('js/table-search.js') }}"></script>
    <script src="{{ asset('js/kategori-keuangan.js') }}"></script>
@endpush
