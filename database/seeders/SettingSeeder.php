<?php

namespace Database\Seeders;

use App\Support\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed pengaturan default kebijakan finansial KUD.
     */
    public function run(): void
    {
        // === Kebijakan Pinjaman ===
        Setting::set('plafond_per_hektar', 10000000, 'pinjaman', 'Plafond per Hektar Lahan Sawit');
        Setting::set('plafond_multiplier_simpanan', 10, 'pinjaman', 'Pengali Saldo Simpanan Pokok + Wajib');
        Setting::set('default_jenis_bunga', 'flat', 'pinjaman', 'Jenis Bunga Default');
        Setting::set('default_persentase_bunga', 1.5, 'pinjaman', 'Persentase Jasa per Bulan Default');
        Setting::set('denda_per_hari', 5000, 'pinjaman', 'Tarif Denda per Hari Keterlambatan');

        // === Pembagian SHU ===
        Setting::set('shu_cadangan_persen', 25, 'shu', 'Persentase Cadangan Koperasi');
        Setting::set('shu_jasa_modal_persen', 35, 'shu', 'Persentase Jasa Usaha / Modal');
        Setting::set('shu_jasa_transaksi_persen', 40, 'shu', 'Persentase Jasa Transaksi / Pinjaman');
    }
}