@extends('admin.layouts.app')

@section('title')
Kategori Sampah - SisaKu
@endsection

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 sm:mb-2 leading-tight">Kategori Sampah</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola jenis sampah, harga, & faktor CO₂</p>
        </div>

    </div>
</div>

<!-- Notification Container -->
<div id="notificationContainer" class="mb-6"></div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Kategori</p>
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">{{ $totalKategori }}</h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Jenis Sampah</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-tags text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Rata-rata CO₂e</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($avgCO2, 2) }}">{{ number_format($avgCO2, 2) }}<span class="text-xs sm:text-sm text-gray-500"> kg CO₂e</span></h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">per kg sampah</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-leaf text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Kategori Sampah Table -->
<div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern overflow-hidden border-modern animate-fade-in-up mb-6 sm:mb-8">
    <div class="mb-3 sm:mb-4 md:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Kategori Sampah</h3>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
            <div class="w-full sm:w-auto">
                <input type="text" id="searchInput" placeholder="Cari kategori..." class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition">
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <button onclick="openBulkUpdateModal()" class="w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-modern text-xs sm:text-sm min-h-[44px]">
                    <i class="fas fa-edit"></i> <span class="hidden sm:inline">Update Harga</span><span class="sm:hidden">Update</span>
                </button>
                <button onclick="openModal()" class="w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-modern text-xs sm:text-sm min-h-[44px]">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Kategori</span><span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Nama</th>
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Deskripsi</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Harga/kg</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Tanggal Berlaku</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">CO₂e/kg</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody id="kategoriTableBody">
                @forelse($kategoriSampah as $kategori)
                <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-xs sm:text-sm font-medium text-gray-800 truncate">{{ $kategori->nama_kategori }}</td>
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-xs sm:text-sm text-gray-700">{{ $kategori->deskripsi ?? '-' }}</td>
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-center text-xs sm:text-sm font-medium text-green-600 whitespace-nowrap">
                        @if($kategori->harga_per_kg)
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-green-50 rounded-full font-medium text-xs">Rp {{ number_format($kategori->harga_per_kg, 0, ',', '.') }}</span>
                        @else
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-gray-100 text-gray-600 rounded-full font-medium text-xs">-</span>
                        @endif
                    </td>
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-center text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                        @if($kategori->tanggal_berlaku)
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-blue-50 text-blue-700 rounded-full font-medium text-xs">{{ \Carbon\Carbon::parse($kategori->tanggal_berlaku)->format('d M Y') }}</span>
                        @else
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-gray-100 text-gray-600 rounded-full font-medium text-xs">-</span>
                        @endif
                    </td>
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-center text-xs sm:text-sm whitespace-nowrap">
                        @if($kategori->konversiDampak)
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-700 rounded-full font-medium text-xs">{{ number_format($kategori->konversiDampak->co2_per_kg, 2) }} kg CO₂e</span>
                        @else
                            <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-gray-100 text-gray-600 rounded-full font-medium text-xs">-</span>
                        @endif
                    </td>
                    <td class="py-3 sm:py-4 px-3 sm:px-4 text-center">
                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                            <!-- Edit -->
                            <button onclick="editKategori({{ $kategori->id }}, {{ json_encode($kategori->nama_kategori) }}, {{ json_encode($kategori->deskripsi) }}, {{ json_encode($kategori->konversiDampak ? $kategori->konversiDampak->co2_per_kg : '') }}, {{ json_encode($kategori->harga_per_kg) }}, {{ json_encode($kategori->tanggal_berlaku) }})"
                                    class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm"
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Delete -->
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
                    <td colspan="6" class="py-12 text-center text-gray-500">
                        <i class="fas fa-tags text-4xl text-gray-300 mb-4"></i>
                        <p>Belum ada kategori sampah</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($kategoriSampah->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $kategoriSampah->links('pagination.custom') }}
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
                    <i class="fas fa-tag text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-white" id="modalTitle">Tambah Kategori Sampah</h3>
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
                               placeholder="Contoh: Plastik HDPE, Kardus, Besi">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi <span class="text-gray-500">(Opsional)</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm"
                                  placeholder="Jelaskan jenis sampah ini secara singkat"></textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">2</div>
                    <h4 class="text-lg font-semibold text-gray-900">Dampak Lingkungan</h4>
                </div>
                
                <div class="pl-11 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Faktor CO₂e per kg <span class="text-gray-500">(Opsional)</span></label>
                        <input type="number" id="co2PerKg" name="co2_per_kg" step="0.01" min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm min-h-[44px]"
                               placeholder="0.00">
                    </div>
                    <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700 font-semibold flex items-center gap-2 mb-3">
                            <i class="fas fa-lightbulb text-yellow-500"></i>
                            Referensi nilai CO₂e per kg
                        </p>
                        <div class="space-y-2 text-xs text-green-700">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div><span class="font-semibold">Plastik:</span> 2.5-3.5 kg CO₂e</div>
                                <div><span class="font-semibold">Besi:</span> 6.0-7.5 kg CO₂e</div>
                                <div><span class="font-semibold">Aluminium:</span> 7.0-8.5 kg CO₂e</div>
                                <div><span class="font-semibold">Kertas:</span> 0.8-1.2 kg CO₂e</div>
                                <div><span class="font-semibold">Kaca:</span> 0.6-0.9 kg CO₂e</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">3</div>
                    <h4 class="text-lg font-semibold text-gray-900">Harga & Periode Berlaku</h4>
                </div>
                
                <div class="pl-11 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga/kg (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="hargaPerKg" name="harga_per_kg" step="100" min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm min-h-[44px]"
                               placeholder="Contoh: 1000">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berlaku <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggalBerlaku" name="tanggal_berlaku"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm min-h-[44px]">
                    </div>
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

<!-- Bulk Update Modal -->
<div id="bulkUpdateModal" class="fixed inset-0 hidden pointer-events-none z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/30 pointer-events-auto" onclick="closeBulkUpdateModal()"></div>
    <div class="bg-white rounded-2xl p-6 sm:p-8 w-full max-w-3xl transform transition-all duration-300 scale-95 opacity-0 pointer-events-auto max-h-[90vh] overflow-y-auto flex flex-col relative z-10" id="bulkUpdateModalContent">
        <div class="sticky top-0 bg-gradient-to-r from-green-500 to-emerald-600 -mx-6 sm:-mx-8 px-6 sm:px-8 py-6 mb-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-sync text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold text-white">Update Harga Massal</h3>
                    <p class="text-sm text-green-100 mt-1">Perbarui harga semua kategori sekaligus</p>
                </div>
            </div>
            <button onclick="closeBulkUpdateModal()" class="text-white/80 hover:text-white transition text-xl p-2 hover:bg-white/20 rounded-lg min-h-[44px] min-w-[44px] flex items-center justify-center flex-shrink-0">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="bulkUpdateForm">
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700"><i class="fas fa-info-circle mr-2"></i>Perbarui harga untuk semua kategori dengan cepat. Perubahan akan langsung diterapkan.</p>
            </div>

            <form id="bulkUpdateFormElement" class="space-y-4">
                @csrf
                <div id="bulkUpdateContainer" class="space-y-3">
                    @foreach($kategoriSampah as $kategori)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow bg-gray-50">
                        <div class="mb-4">
                            <p class="font-semibold text-gray-900 text-sm">{{ $kategori->nama_kategori }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $kategori->deskripsi ?? '-' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Harga/kg (Rp)</label>
                                <input type="hidden" name="updates[{{ $loop->index }}][id]" value="{{ $kategori->id }}">
                                <input type="number" name="updates[{{ $loop->index }}][harga_per_kg]" 
                                       value="{{ $kategori->harga_per_kg }}" step="100" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all min-h-[44px]"
                                       required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">Tanggal Berlaku</label>
                                <input type="date" name="updates[{{ $loop->index }}][tanggal_berlaku]" 
                                       value="{{ $kategori->tanggal_berlaku }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all min-h-[44px]"
                                       required>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 pt-6 flex gap-3 sticky bottom-0 bg-white">
                    <button type="button" onclick="closeBulkUpdateModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-all min-h-[44px]">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all min-h-[44px] flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i><span>Simpan Semua</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/modal-handlers.js') }}"></script>
    <script src="{{ asset('js/table-search.js') }}"></script>
    <script src="{{ asset('js/kategori-sampah.js') }}"></script>
@endpush
