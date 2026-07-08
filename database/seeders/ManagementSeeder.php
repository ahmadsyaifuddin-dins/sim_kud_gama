<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagementSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Mengatur komposisi jabatan persis 18 orang
        // Jabatan inti = 1 orang | Humas = 2 orang | Anggota Pengurus = 6 orang
        $jabatanList = array_merge(
            ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Pengawas 1', 'Pengawas 2', 'Pengawas 3'],
            array_fill(0, 3, 'Humas'),
            array_fill(0, 8, 'Anggota Pengurus')
        );

        foreach ($jabatanList as $jabatan) {
            DB::table('managements')->insert([
                'nama' => $faker->name,
                'jabatan' => $jabatan,
                'no_hp' => $faker->numerify('081#########'), // Terkunci di format 081xxxxxxxx (12 digit)
                'periode_mulai' => '2025',
                'periode_selesai' => '2030',
                'is_active' => $faker->boolean(95) ? 1 : 0, // 80% kemungkinan aktif
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}