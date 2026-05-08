<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Insert Data Asli (Putri Ayunda Saraswati)
        DB::table('members')->insert([
            'nomor_anggota' => 'KUD-GM-0001',
            'status' => 'active',
            'nik' => '6312819728912211',
            'nama_lengkap' => 'Putri Ayunda Saraswati',
            'tempat_lahir' => 'BANJARMASIN',
            'tanggal_lahir' => '2000-07-09',
            'jenis_kelamin' => 'L', // Sesuai data asli yang diberikan
            'alamat_lengkap' => 'Jalan Hamengkubowono No 3',
            'dusun' => 'Muara Ujung',
            'desa' => 'Telaga Sari',
            'no_hp' => '085849910396',
            'pekerjaan' => 'Dewan Legislatif',
            'luasan_lahan' => 100,
            'tanggal_bergabung' => '2025-12-23',
            'foto' => 'uploads/members/photos/1774938183_foto_Dayeon pas foto SMA (2).jpeg',
            'status_cetak' => 1,
            'tanggal_cetak' => '2026-03-31 14:25:00',
            'created_at' => '2025-12-23 06:36:05',
            'updated_at' => '2026-03-31 14:25:00',
            'file_sertifikat_tanah' => 'members-docs/jIYITBIzDbCCL49zyQT7Du5Y1YZzrKpmlxAn629v.pdf',
            'file_ktp' => 'members-docs/XjhSCeuOJsD03WJExgUrbsyhDyl3Pg624UvYgQED.jpg',
            'file_kk' => 'members-docs/40jXKvETZsz7GwohC828wx46ouQBIagk2S27RT0K.jpg',
            'biaya_pendaftaran' => 150000,
            'file_bukti_bayar' => 'uploads/members/payments/1774938183_payment_04 AKTA LAHIR_page-0001.jpg',
            'tanggal_bayar' => '2025-12-23',
        ]);

        // 2. Insert Data Asli (Mariyani)
        DB::table('members')->insert([
            'nomor_anggota' => 'KUD-GM-0002',
            'status' => 'active',
            'nik' => '4435239800423983',
            'nama_lengkap' => 'Mariyani',
            'tempat_lahir' => 'Palangka Raya',
            'tanggal_lahir' => '2004-06-20',
            'jenis_kelamin' => 'P',
            'alamat_lengkap' => 'Jalan Melati No 8, RT 001',
            'dusun' => 'Dusun Melati',
            'desa' => 'Telaga Sari',
            'no_hp' => '085845876833',
            'pekerjaan' => 'Mahasiwa',
            'luasan_lahan' => 2.5,
            'tanggal_bergabung' => '2025-12-23',
            'foto' => 'uploads/members/photos/1778204667_foto_aya-profile.jpg',
            'status_cetak' => 1,
            'tanggal_cetak' => '2026-05-08 09:44:52',
            'created_at' => '2025-12-23 08:00:23',
            'updated_at' => '2026-05-08 09:44:52',
            'file_sertifikat_tanah' => 'members-docs/mk03qNuWcBsjLi8Rxp4YEpNZMDyJlIl2U3jCI866.pdf',
            'file_ktp' => 'members-docs/iUtpQGzvl7m0i0RH2w0L4vWEj1GxnCo8LFpkXbfe.jpg',
            'file_kk' => 'members-docs/Dkb61nkPNYN3MpeC32YHEjIOqehzXrlzHEW1q9kT.jpg',
            'biaya_pendaftaran' => 150000,
            'file_bukti_bayar' => 'members-payments/khOcdceRv3uHAJPDmZddMAAFKfIoOwCXIRZEjxnZ.webp',
            'tanggal_bayar' => '2025-12-23',
        ]);

        // 3. Generate 6 Data Dummy dengan Faker
        for ($i = 3; $i <= 8; $i++) {
            $gender = $faker->randomElement(['L', 'P']);

            DB::table('members')->insert([
                'nomor_anggota' => 'KUD-GM-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'status' => $faker->randomElement(['active', 'inactive']),
                'nik' => $faker->nik(),
                'nama_lengkap' => $faker->name($gender === 'L' ? 'male' : 'female'),
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
                'jenis_kelamin' => $gender,
                'alamat_lengkap' => $faker->streetAddress(),
                'dusun' => 'Dusun '.$faker->numberBetween(1, 5),
                'desa' => 'Telaga Sari',
                'no_hp' => $faker->phoneNumber(),
                'pekerjaan' => $faker->jobTitle(),
                'luasan_lahan' => $faker->randomFloat(2, 0.5, 10), // Random antara 0.5 hingga 10 hektar
                'tanggal_bergabung' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d'),
                'foto' => null, // Simulasi belum upload data
                'status_cetak' => 0,
                'tanggal_cetak' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'file_sertifikat_tanah' => null,
                'file_ktp' => null,
                'file_kk' => null,
                'biaya_pendaftaran' => 150000,
                'file_bukti_bayar' => null,
                'tanggal_bayar' => null,
            ]);
        }
    }
}
