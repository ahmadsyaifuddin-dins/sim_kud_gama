<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SavingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $jenisSimpanan = ['pokok', 'wajib', 'sukarela'];
        
        // Mengambil ID member dan user secara acak dari database
        $memberIds = DB::table('members')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Pastikan ada data user dan member sebelum seeding
        if(empty($memberIds) || empty($userIds)) return;

        for ($i = 1; $i <= 20; $i++) { // Dibuat 20 agar rekap keuangannya banyak
            $jenis = $faker->randomElement($jenisSimpanan);
            $jumlah = ($jenis == 'pokok') ? 100000 : (($jenis == 'wajib') ? 50000 : $faker->randomElement([20000, 50000, 100000]));

            DB::table('savings')->insert([
                'member_id' => $faker->randomElement($memberIds),
                'jenis_simpanan' => $jenis,
                'jumlah' => $jumlah,
                'tanggal_bayar' => $faker->dateTimeBetween('2026-01-01', '2026-05-20')->format('Y-m-d'),
                'keterangan' => 'Pembayaran simpanan ' . $jenis,
                'user_id' => $faker->randomElement($userIds),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}