<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ManagementSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $jabatanList = ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Pengawas 1', 'Pengawas 2', 'Anggota Pengurus', 'Humas'];

        for ($i = 0; $i < 10; $i++) {
            DB::table('managements')->insert([
                'nama' => $faker->name,
                'jabatan' => $jabatanList[$i % count($jabatanList)],
                'no_hp' => $faker->phoneNumber,
                'periode_mulai' => '2025',
                'periode_selesai' => '2030',
                'is_active' => $faker->boolean(80) ? 1 : 0, // 80% aktif
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}