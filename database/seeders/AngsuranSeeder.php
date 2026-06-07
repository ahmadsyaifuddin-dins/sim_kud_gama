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
        
        // Mengambil HANYA pinjaman yang disetujui (Belum Lunas) atau Lunas untuk dicatat angsurannya
        $pinjamanAktif = DB::table('pinjaman')
            ->whereIn('status', ['disetujui', 'lunas'])
            ->get();
            
        $userIds = DB::table('users')->pluck('id')->toArray();

        if($pinjamanAktif->isEmpty() || empty($userIds)) return;

        foreach ($pinjamanAktif as $pinjaman) {
            // Jika statusnya Lunas, angsurannya full. Jika disetujui (Belum lunas), angsurannya baru sebagian (misal 1-3 kali).
            $jumlahAngsuranDibayar = ($pinjaman->status == 'lunas') ? $pinjaman->lama_angsuran : rand(1, max(1, $pinjaman->lama_angsuran - 1));
            $angsuranPerBulan = $pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran;

            for ($ke = 1; $ke <= $jumlahAngsuranDibayar; $ke++) {
                DB::table('angsuran')->insert([
                    'pinjaman_id' => $pinjaman->id,
                    'angsuran_ke' => $ke,
                    'jumlah_bayar' => round($angsuranPerBulan, 2),
                    // Mensimulasikan pembayaran rutin bulanan dari tanggal pencairan, pastikan tidak melebihi tgl hari ini (20 Mei 2026)
                    'tanggal_bayar' => Carbon::parse($pinjaman->tanggal_pencairan)->addMonths($ke)->format('Y-m-d'),
                    'user_id' => $faker->randomElement($userIds),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}