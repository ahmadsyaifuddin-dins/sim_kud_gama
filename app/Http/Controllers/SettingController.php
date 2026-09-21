<?php

namespace App\Http\Controllers;

use App\Support\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Halaman pengaturan kebijakan finansial (plafond, bunga, denda, SHU).
     */
    public function index()
    {
        $settings = [
            // Kelompok Kebijakan Pinjaman
            'plafond_per_hektar' => (float) Setting::get('plafond_per_hektar', 10000000),
            'plafond_multiplier_simpanan' => (float) Setting::get('plafond_multiplier_simpanan', 10),
            'default_jenis_bunga' => Setting::get('default_jenis_bunga', 'flat'),
            'default_persentase_bunga' => (float) Setting::get('default_persentase_bunga', 1.5),
            'denda_per_hari' => (float) Setting::get('denda_per_hari', 5000),

            // Kelompok Pembagian SHU
            'shu_cadangan_persen' => (float) Setting::get('shu_cadangan_persen', 25),
            'shu_jasa_modal_persen' => (float) Setting::get('shu_jasa_modal_persen', 35),
            'shu_jasa_transaksi_persen' => (float) Setting::get('shu_jasa_transaksi_persen', 40),
        ];

        return view('settings.index', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'plafond_per_hektar' => 'required|numeric|min:0',
            'plafond_multiplier_simpanan' => 'required|numeric|min:1',
            'default_jenis_bunga' => 'required|in:flat,menurun',
            'default_persentase_bunga' => 'required|numeric|min:0|max:12',
            'denda_per_hari' => 'required|numeric|min:0',

            'shu_cadangan_persen' => 'required|numeric|min:0|max:100',
            'shu_jasa_modal_persen' => 'required|numeric|min:0|max:100',
            'shu_jasa_transaksi_persen' => 'required|numeric|min:0|max:100',
        ]);

        Setting::set('plafond_per_hektar', $validated['plafond_per_hektar'], 'pinjaman');
        Setting::set('plafond_multiplier_simpanan', $validated['plafond_multiplier_simpanan'], 'pinjaman');
        Setting::set('default_jenis_bunga', $validated['default_jenis_bunga'], 'pinjaman');
        Setting::set('default_persentase_bunga', $validated['default_persentase_bunga'], 'pinjaman');
        Setting::set('denda_per_hari', $validated['denda_per_hari'], 'pinjaman');

        Setting::set('shu_cadangan_persen', $validated['shu_cadangan_persen'], 'shu');
        Setting::set('shu_jasa_modal_persen', $validated['shu_jasa_modal_persen'], 'shu');
        Setting::set('shu_jasa_transaksi_persen', $validated['shu_jasa_transaksi_persen'], 'shu');

        return redirect()->route('settings.index')->with('success', 'Pengaturan kebijakan finansial berhasil diperbarui.');
    }
}