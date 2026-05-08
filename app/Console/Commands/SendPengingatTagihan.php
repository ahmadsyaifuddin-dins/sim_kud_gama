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
        // Ambil pinjaman yang disetujui dan belum lunas
        $pinjamanAktif = Pinjaman::with('member')
            ->where('status', 'disetujui')
            ->whereNotNull('tanggal_pencairan')
            ->get();

        $besok = Carbon::tomorrow();

        foreach ($pinjamanAktif as $pinjaman) {
            $tanggalPencairan = Carbon::parse($pinjaman->tanggal_pencairan);

            // Cek apakah tanggal hari pencairan sama dengan tanggal besok
            if ($tanggalPencairan->day === $besok->day) {
                $cicilan = $pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran;
                $jumlahFormat = 'Rp '.number_format($cicilan, 0, ',', '.');
                $member = $pinjaman->member;

                if ($member && $member->no_hp) {
                    // Penulisan tanggal menggunakan format Indonesia sesuai locale
                    $tanggalJatuhTempo = $besok->translatedFormat('d F Y');
                    $pesan = "Halo {$member->nama_lengkap},\n\nMengingatkan bahwa besok ({$tanggalJatuhTempo}) adalah tanggal jatuh tempo angsuran pinjaman Anda sebesar *{$jumlahFormat}*.\n\nMohon siapkan dana untuk pembayaran. Abaikan pesan ini jika sudah membayar.";

                    WhatsAppService::send($member->no_hp, $pesan);
                }
            }
        }
    }
}
