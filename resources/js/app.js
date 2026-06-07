import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
Alpine.start();

// Buat Swal tersedia secara global jika suatu saat butuh dipanggil manual
window.Swal = Swal;

// GLOBAL EVENT DELEGATION UNTUK KONFIRMASI
document.addEventListener('submit', function(e) {
    // Cek apakah form yang disubmit memiliki class 'confirm-action'
    if (e.target && e.target.classList.contains('confirm-action')) {
        e.preventDefault(); // Tahan dulu form agar tidak langsung terkirim

        const form = e.target;
        
        // Ambil custom text dari atribut data- (jika ada), jika tidak gunakan default
        const title = form.getAttribute('data-swal-title') || 'Apakah Anda yakin?';
        const text = form.getAttribute('data-swal-text') || 'Data ini akan dihapus dan tidak dapat dikembalikan!';
        const icon = form.getAttribute('data-swal-icon') || 'warning';
        const confirmBtn = form.getAttribute('data-swal-confirm') || 'Ya, Hapus!';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Warna merah (Tailwind red-500)
            cancelButtonColor: '#64748b', // Warna abu-abu (Tailwind slate-500)
            confirmButtonText: confirmBtn,
            cancelButtonText: 'Batal',
            reverseButtons: true // UX: Tombol aksi utama biasanya di kanan
        }).then((result) => {
            if (result.isConfirmed) {
                // Tambahkan loading state pada SweetAlert saat memproses
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form sebenarnya
                form.submit();
            }
        });
    }
});