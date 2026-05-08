Untuk mengaktifkan penjadwalan di server local (XAMPP/Laragon) ketika terminal/CMD sedang terbuka:

php artisan schedule:work

Perintah ini akan membuat Laravel aktif mengecek setiap menit apakah ada task yang sudah masuk jadwalnya (misalnya jam 08:00 WITA) dan akan langsung mengeksekusinya.

Jika Anda hanya ingin mengetes apakah pesan WhatsApp-nya terkirim tanpa harus menunggu jam 08:00, Anda bisa memaksa eksekusi command tersebut secara manual di CMD dengan perintah:

php artisan kud:pengingat-tagihan
