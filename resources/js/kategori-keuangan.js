function editKategori(id, nama, deskripsi, tipe) {
    document.getElementById('kategoriId').value = id;
    document.getElementById('namaKategori').value = nama;
    document.getElementById('deskripsi').value = deskripsi || '';

    if (tipe === 'masuk') {
        document.getElementById('tipe_masuk').checked = true;
    } else {
        document.getElementById('tipe_keluar').checked = true;
    }

    openModal(id);
}

function confirmDelete() {
    if (deleteId) {
        fetch(`/admin/master-data/kategori-keuangan/${deleteId}`, {
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
                showNotification(data.message || 'Kategori keuangan berhasil dihapus', 'success');
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

function initKategoriKeuanganForm() {
    const kategoriForm = document.getElementById('kategoriForm');
    if (kategoriForm) {
        kategoriForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = formData.get('id');

            const url = id ? `/admin/master-data/kategori-keuangan/${id}` : '/admin/master-data/kategori-keuangan';
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
                    showNotification(data.message || 'Kategori keuangan berhasil disimpan', 'success');
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

function initRadioButtonStyling() {
    const radioButtons = document.querySelectorAll('input[type="radio"][name="jenis"]');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[type="radio"][name="jenis"]').forEach(r => {
                const label = r.closest('label');
                const dot = label.querySelector('.w-3.h-3');

                if (r.checked) {
                    if (r.value === 'masuk') {
                        label.querySelector('.p-4').classList.add('border-green-500', 'bg-green-50');
                        label.querySelector('.p-4').classList.remove('border-gray-200');
                        label.querySelector('.w-5.h-5').classList.add('border-green-500');
                    } else {
                        label.querySelector('.p-4').classList.add('border-red-500', 'bg-red-50');
                        label.querySelector('.p-4').classList.remove('border-gray-200');
                        label.querySelector('.w-5.h-5').classList.add('border-red-500');
                    }
                    dot.classList.remove('hidden');
                } else {
                    label.querySelector('.p-4').classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
                    label.querySelector('.p-4').classList.add('border-gray-200');
                    label.querySelector('.w-5.h-5').classList.remove('border-green-500', 'border-red-500');
                    dot.classList.add('hidden');
                }
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    initTableSearch();
    initKategoriKeuanganForm();
    initRadioButtonStyling();
});
