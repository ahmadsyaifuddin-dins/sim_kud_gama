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

        // 1. Jabatan inti yang HANYA boleh ada 1
        $jabatanInti = ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara'];

        // 2. Jabatan tambahan yang boleh lebih dari 1
        $jabatanTambahan = ['Pengawas 1', 'Pengawas 2', 'Anggota Pengurus', 'Humas'];

        // 3. Gabungkan ke dalam satu array keranjang (Total target = 18)
        $semuaJabatan = $jabatanInti; // Masukkan 4 jabatan inti dulu

        // Isi sisa kuota (18 total - 4 inti = 14 slot tersisa) secara acak
        for ($i = 0; $i < 14; $i++) {
            $semuaJabatan[] = $faker->randomElement($jabatanTambahan);
        }

        // Opsional: Jika ingin urutannya diacak, uncomment kode di bawah ini.
        // Tapi untuk pengurus, biasanya Ketua, Wakil, dkk lebih bagus berada di urutan atas (ID awal).
        // shuffle($semuaJabatan);

        // 4. Eksekusi Insert ke Database
        foreach ($semuaJabatan as $jabatan) {
            DB::table('managements')->insert([
                'nama' => $faker->name,
                'jabatan' => $jabatan,
                // Menggunakan numerify agar formatnya terkunci di awalan 081 dengan total 12 digit
                'no_hp' => $faker->numerify('081#########'),
                'periode_mulai' => '2025',
                'periode_selesai' => '2030',
                'is_active' => $faker->boolean(90) ? 1 : 0, // 90% aktif
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
