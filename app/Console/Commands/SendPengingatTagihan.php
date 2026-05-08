<?php

namespace App\Console\Commands;

use App\Models\Pinjaman;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendPengingatTagihan extends Command
{
    protected $signature = 'kud:pengingat-tagihan';

    protected $description = 'Kirim notifikasi WA untuk tagihan pinjaman yang jatuh tempo besok';

    public function handle()
    {
        $this->info('Memulai pengecekan data tagihan jatuh tempo...');

        // Memanggil method statis dan mengirimkan instance '$this' agar bisa print teks ke terminal
        $pesanTerkirim = self::prosesPengingatOtomatis($this);

        if ($pesanTerkirim > 0) {
            $this->info("Proses Selesai! Total {$pesanTerkirim} pesan WA telah dikirim.");
        } else {
            $this->warn('Proses Selesai! Tidak ada tagihan yang jatuh tempo besok.');
        }
    }

    /**
     * Method ini bisa dipanggil oleh Controller maupun Command
     */
    public static function prosesPengingatOtomatis($console = null): int
    {
        $pinjamanAktif = Pinjaman::with('member')
            ->where('status', 'disetujui')
            ->whereNotNull('tanggal_pencairan')
            ->get();

        $besok = Carbon::tomorrow();
        $pesanTerkirim = 0;

        foreach ($pinjamanAktif as $pinjaman) {
            $tanggalPencairan = Carbon::parse($pinjaman->tanggal_pencairan);

            if ($tanggalPencairan->day === $besok->day) {
                $cicilan = $pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran;
                $jumlahFormat = 'Rp '.number_format($cicilan, 0, ',', '.');
                $member = $pinjaman->member;

                if ($member && $member->no_hp) {
                    $tanggalJatuhTempo = $besok->translatedFormat('d F Y');

                    // Pesan detail yang sudah kita buat sebelumnya
                    $pesan = "Halo *{$member->nama_lengkap}*,\n\nInformasi pengingat dari *KUD Gajah Mada*.\n\nMengingatkan bahwa besok, tanggal *{$tanggalJatuhTempo}* adalah batas waktu pembayaran angsuran pinjaman Anda.\n\n*Detail Tagihan:*\n• Nominal Bayar: *{$jumlahFormat}*\n\nMohon persiapkan dana dan lakukan pembayaran langsung di loket kantor KUD Gajah Mada. Pembayaran tepat waktu akan menghindarkan Anda dari denda keterlambatan.\n\n_(Abaikan pesan otomatis ini jika Anda sudah melakukan pembayaran)_.\n\nTerima kasih.";

                    WhatsAppService::send($member->no_hp, $pesan);
                    $pesanTerkirim++;

                    // Jika dipanggil dari terminal, tampilkan log nama anggotanya
                    if ($console) {
                        $console->line("-> [Sukses] Mengirim pengingat ke: {$member->nama_lengkap} ({$member->no_hp})");
                    }
                }
            }
        }

        // Kembalikan jumlah pesan yang berhasil dikirim (angka)
        return $pesanTerkirim;
    }
}
