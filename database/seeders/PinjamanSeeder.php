<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PinjamanSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $statusPinjaman = ['menunggu', 'disetujui', 'ditolak', 'lunas'];
        
        $memberIds = DB::table('members')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        if(empty($memberIds) || empty($userIds)) return;

        for ($i = 1; $i <= 15; $i++) {
            $status = $faker->randomElement($statusPinjaman);
            $tglPengajuan = $faker->dateTimeBetween('2025-10-01', '2026-05-20');
            
            DB::table('pinjaman')->insert([
                'member_id' => $faker->randomElement($memberIds),
                'tanggal_pengajuan' => $tglPengajuan->format('Y-m-d'),
                'jumlah_pinjaman' => $faker->randomElement([1000000, 2500000, 5000000, 10000000]),
                'lama_angsuran' => $faker->randomElement([3, 6, 12, 24]), // Bulan
                'keperluan' => $faker->sentence(),
                'status' => $status,
                'tanggal_pencairan' => in_array($status, ['disetujui', 'lunas']) ? (clone $tglPengajuan)->modify('+3 days')->format('Y-m-d') : null,
                'user_id' => $faker->randomElement($userIds),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}