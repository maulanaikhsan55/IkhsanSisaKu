function editKategori(id, nama, deskripsi, co2, harga, tanggal) {
    document.getElementById('kategoriId').value = id;
    document.getElementById('namaKategori').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';
    document.getElementById('co2PerKg').value = co2 || '';
    document.getElementById('hargaPerKg').value = harga || '';
    document.getElementById('tanggalBerlaku').value = tanggal || '';
    
    openModal(id);
}

function confirmDelete() {
    if (deleteId) {
        fetch(`/admin/master-data/kategori-sampah/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                showNotification(data.message || 'Kategori sampah berhasil dihapus', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                closeDeleteModal();
                showNotification(data.message || 'Terjadi kesalahan saat menghapus kategori', 'error');
            }
        })
        .catch(error => {
            closeDeleteModal();
            showNotification('Terjadi kesalahan saat menghapus kategori', 'error');
        });
    }
}

function initKategoriSampahForm() {
    const kategoriForm = document.getElementById('kategoriForm');
    if (kategoriForm) {
        kategoriForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = formData.get('id');

            const url = id ? `/admin/master-data/kategori-sampah/${id}` : '/admin/master-data/kategori-sampah';
            const method = id ? 'PUT' : 'POST';

            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    showNotification(data.message || 'Kategori sampah berhasil disimpan', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Terjadi kesalahan saat menyimpan data', 'error');
                }
            })
            .catch(error => {
                showNotification('Terjadi kesalahan saat menyimpan data', 'error');
            });
        });
    }
}

function initDateInputMax() {
    const today = new Date().toISOString().split('T')[0];
    const tanggalInput = document.getElementById('tanggalBerlaku');
    if (tanggalInput) {
        tanggalInput.max = today;
    }
}

function openBulkUpdateModal() {
    const modal = document.getElementById('bulkUpdateModal');
    const modalContent = document.getElementById('bulkUpdateModalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('pointer-events-none');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeBulkUpdateModal() {
    const modal = document.getElementById('bulkUpdateModal');
    const modalContent = document.getElementById('bulkUpdateModalContent');
    
    modalContent.classList.add('scale-95', 'opacity-0');
    modalContent.classList.remove('scale-100', 'opacity-100');
    
    setTimeout(() => {
        modal.classList.add('pointer-events-none', 'hidden');
    }, 300);
}

function initBulkUpdateForm() {
    const bulkForm = document.getElementById('bulkUpdateFormElement');
    if (bulkForm) {
        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const updates = [];

            const kategoriCount = document.querySelectorAll('input[name*="updates"][name*="harga_per_kg"]').length;
            
            for (let i = 0; i < kategoriCount; i++) {
                const id = formData.get(`updates[${i}][id]`);
                const harga = formData.get(`updates[${i}][harga_per_kg]`);
                const tanggal = formData.get(`updates[${i}][tanggal_berlaku]`);

                if (id && harga && tanggal) {
                    updates.push({
                        id: id,
                        harga_per_kg: harga,
                        tanggal_berlaku: tanggal
                    });
                }
            }

            fetch('/admin/master-data/kategori-sampah/bulk-update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ updates: updates })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeBulkUpdateModal();
                    showNotification(data.message || 'Harga berhasil diupdate', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message || 'Terjadi kesalahan saat update harga', 'error');
                }
            })
            .catch(error => {
                showNotification('Terjadi kesalahan saat update harga', 'error');
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initDateInputMax();
    initTableSearch();
    initKategoriSampahForm();
    initBulkUpdateForm();
});
