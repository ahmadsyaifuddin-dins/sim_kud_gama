<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Menggunakan zona waktu Makassar sesuai settingan awal aplikasi kita
        $now = Carbon::now('Asia/Makassar');

        // 1. Data Akun Utama (Asli)
        $users = [
            [
                'name' => 'Aya',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pimpinan KUD',
                'email' => 'pimpinan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'pimpinan',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // 2. Generate 13 Data Akun Dummy
        for ($i = 1; $i <= 13; $i++) {
            $name = $faker->name();

            // Membuat format email yang natural (contoh: budisantoso88@gmail.com)
            // Menghapus spasi/tanda baca dari nama, lalu diubah ke huruf kecil semua
            $cleanName = strtolower(preg_replace('/[^a-zA-Z]/', '', $name));
            $emailUsername = $cleanName.$faker->numberBetween(10, 999);

            $users[] = [
                'name' => $name,
                'email' => $emailUsername.'@gmail.com',
                'password' => Hash::make('password'), // Semua password diseragamkan
                'role' => 'admin', // Asumsi akun tambahan ini adalah operator/admin KUD
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert semua data (15 akun) ke dalam database sekaligus
        User::insert($users);
    }
}
