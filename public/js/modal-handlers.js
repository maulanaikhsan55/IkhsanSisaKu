let deleteId = null;

function openModal(id = null) {
    const modal = document.getElementById('kategoriModal');
    const modalContent = document.getElementById('modalContent');

    if (id) {
        document.getElementById('modalTitle').textContent = 'Edit Kategori';
    } else {
        document.getElementById('modalTitle').textContent = 'Tambah Kategori';
        document.getElementById('kategoriForm').reset();
        document.getElementById('kategoriId').value = '';
    }

    modal.classList.remove('hidden');
    if (modal.classList.contains('pointer-events-none')) {
        modal.classList.remove('pointer-events-none');
    }
    
    setTimeout(() => {
        if (modalContent) {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('kategoriModal');
    const modalContent = document.getElementById('modalContent');

    if (modalContent) {
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
    }

    setTimeout(() => {
        modal.classList.add('hidden');
        if (modal.classList.contains('pointer-events-none') === false) {
            modal.classList.add('pointer-events-none');
        }
    }, 300);
}

function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    modal.classList.remove('hidden');
    if (modal.classList.contains('pointer-events-none')) {
        modal.classList.remove('pointer-events-none');
    }
    
    setTimeout(() => {
        if (modalContent) {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    if (modalContent) {
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
    }

    setTimeout(() => {
        modal.classList.add('hidden');
        if (modal.classList.contains('pointer-events-none') === false) {
            modal.classList.add('pointer-events-none');
        }
        deleteId = null;
    }, 300);
}

function deleteKategori(id, nama) {
    deleteId = id;
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus kategori "${nama}"?`;
    openDeleteModal();
}
