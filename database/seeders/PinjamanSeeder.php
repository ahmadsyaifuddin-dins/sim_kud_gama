<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PinjamanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $memberIds = DB::table('members')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($memberIds) || empty($userIds)) {
            return;
        }

        // --- MANAJEMEN KUOTA STATUS PINJAMAN ---
        // Kita siapkan tepat: 15 disetujui, 5 lunas, 5 menunggu, 3 ditolak (Total 28 Data)
        $statuses = array_merge(
            array_fill(0, 15, 'disetujui'),
            array_fill(0, 5, 'lunas'),
            array_fill(0, 5, 'menunggu'),
            array_fill(0, 3, 'ditolak')
        );

        // Acak posisinya agar tanggal dan urutan ID-nya terlihat natural
        shuffle($statuses);

        // --- DAFTAR KEPERLUAN PINJAMAN REALISTIS ---
        // Disesuaikan dengan demografi anggota KUD pada umumnya
        $keperluanList = [
            'Modal pembelian pupuk dan bibit kelapa sawit',
            'Biaya pendidikan anak masuk perguruan tinggi',
            'Renovasi rumah tempat tinggal',
            'Pembelian alat pertanian (mesin traktor mini)',
            'Tambahan modal usaha warung sembako',
            'Biaya pengobatan dan rawat inap keluarga',
            'Pembelian sepeda motor untuk transportasi ke kebun',
            'Modal usaha ternak sapi/kambing',
            'Biaya hajatan/pernikahan anak',
            'Pembelian racun rumput dan biaya perawatan lahan',
            'Perluasan lahan pertanian/perkebunan',
            'Perbaikan mesin perahu/kelotok untuk nelayan',
        ];

        foreach ($statuses as $status) {
            $tglPengajuan = $faker->dateTimeBetween('2025-10-01', '2026-05-20');

            // Tanggal pencairan hanya ada jika status disetujui atau lunas
            $tanggalPencairan = in_array($status, ['disetujui', 'lunas'])
                ? (clone $tglPengajuan)->modify('+3 days')->format('Y-m-d')
                : null;

            DB::table('pinjaman')->insert([
                'member_id' => $faker->randomElement($memberIds),
                'tanggal_pengajuan' => $tglPengajuan->format('Y-m-d'),
                'jumlah_pinjaman' => $faker->randomElement([1000000, 2500000, 5000000, 10000000, 15000000]),
                'lama_angsuran' => $faker->randomElement([3, 6, 12, 24]), // Bulan

                // --- PERUBAHAN DI SINI ---
                // Mengambil secara acak dari array keperluan yang sudah kita buat
                'keperluan' => $faker->randomElement($keperluanList),

                'status' => $status,
                'tanggal_pencairan' => $tanggalPencairan,
                'user_id' => $faker->randomElement($userIds),
                'created_at' => $tglPengajuan->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
