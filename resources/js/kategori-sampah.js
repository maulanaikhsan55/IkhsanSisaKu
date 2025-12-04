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
            console.error('Error:', error);
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
                console.error('Error:', error);
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

document.addEventListener('DOMContentLoaded', function() {
    initDateInputMax();
    initTableSearch();
    initKategoriSampahForm();
});
