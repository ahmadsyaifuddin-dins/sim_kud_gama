<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AngsuranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Mengambil HANYA pinjaman yang disetujui (Belum Lunas) atau Lunas
        $pinjamanAktif = DB::table('pinjaman')
            ->whereIn('status', ['disetujui', 'lunas'])
            ->get();
            
        $userIds = DB::table('users')->pluck('id')->toArray();

        if($pinjamanAktif->isEmpty() || empty($userIds)) return;

        // Mendapatkan tanggal aktual saat script dijalankan (berdasarkan zona waktu Makassar)
        $now = Carbon::now('Asia/Makassar');

        foreach ($pinjamanAktif as $pinjaman) {
            // Jika status Lunas, angsuran full. Jika Disetujui, angsuran baru berjalan sebagian
            $jumlahAngsuranDibayar = ($pinjaman->status === 'lunas') 
                ? $pinjaman->lama_angsuran 
                : rand(1, max(1, $pinjaman->lama_angsuran - 1));
                
            $angsuranPerBulan = $pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran;
            $tanggalPencairan = Carbon::parse($pinjaman->tanggal_pencairan);

            for ($ke = 1; $ke <= $jumlahAngsuranDibayar; $ke++) {
                // Tambah bulan berdasarkan angsuran ke-
                $tanggalBayar = $tanggalPencairan->copy()->addMonths($ke);

                // Validasi Logika: Jangan buat data angsuran jika tanggal bayarnya melebihi hari ini
                if ($tanggalBayar->greaterThan($now)) {
                    break;
                }

                // Simulasi file upload public/uploads (70% peluang user upload bukti, sisanya bayar tunai/langsung)
                $buktiBayar = $faker->boolean(70) 
                    ? 'uploads/angsuran/dummy-bukti-bayar-' . $faker->uuid() . '.jpg' 
                    : null;

                DB::table('angsuran')->insert([
                    'pinjaman_id'   => $pinjaman->id,
                    'angsuran_ke'   => $ke,
                    'jumlah_bayar'  => round($angsuranPerBulan, 2),
                    'tanggal_bayar' => $tanggalBayar->format('Y-m-d'),
                    'bukti_bayar'   => $buktiBayar,
                    'user_id'       => $faker->randomElement($userIds),
                    'created_at'    => $tanggalBayar->format('Y-m-d H:i:s'),
                    'updated_at'    => $tanggalBayar->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}