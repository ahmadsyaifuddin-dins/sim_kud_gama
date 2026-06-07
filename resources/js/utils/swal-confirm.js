import Swal from 'sweetalert2';

// Buat Swal tersedia secara global
window.Swal = Swal;

document.addEventListener('submit', function(e) {
    if (e.target && e.target.classList.contains('confirm-action')) {
        e.preventDefault();

        const form = e.target;
        const title = form.getAttribute('data-swal-title') || 'Apakah Anda yakin?';
        const text = form.getAttribute('data-swal-text') || 'Data ini akan dihapus dan tidak dapat dikembalikan!';
        const icon = form.getAttribute('data-swal-icon') || 'warning';
        const confirmBtn = form.getAttribute('data-swal-confirm') || 'Ya, Hapus!';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: confirmBtn,
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    }
});