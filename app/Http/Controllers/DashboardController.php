<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\Saving;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK UTAMA
        $totalAnggota = Member::count();
        $belumCetak = Member::where('status_cetak', false)->count();
        $totalLahan = Member::sum('luasan_lahan');

        // 2. KEUANGAN KUD (Pemasukan & Pengeluaran)
        // Pemasukan: Pendaftaran + Simpanan + Angsuran Masuk
        $uangPendaftaran = Member::whereNotNull('file_bukti_bayar')->count() * 150000;
        $uangSimpanan = Saving::sum('jumlah');
        $uangAngsuran = Angsuran::sum('jumlah_bayar');

        $totalPemasukan = $uangPendaftaran + $uangSimpanan + $uangAngsuran;

        // Pengeluaran: Total Pinjaman yang disetujui / dicairkan
        $totalPinjamanKeluar = Pinjaman::whereIn('status', ['disetujui', 'lunas'])->sum('jumlah_pinjaman');

        // Notifikasi: Pinjaman yang menunggu persetujuan
        $pinjamanPending = Pinjaman::where('status', 'menunggu')->count();

        // 3. STATISTIK STATUS ANGGOTA
        $statusCounts = [
            'active' => Member::where('status', 'active')->count(),
            'inactive' => Member::where('status', 'inactive')->count(),
            'stopped' => Member::where('status', 'stopped')->count(),
            'pending' => Member::where('status', 'pending')->count(),
        ];

        // 4. CHART DATA (Sebaran Dusun)
        $dusunStats = Member::select('dusun', DB::raw('count(*) as total'))
            ->groupBy('dusun')
            ->pluck('total', 'dusun');

        $labels = $dusunStats->keys();
        $data = $dusunStats->values();

        return view('dashboard', compact(
            'totalAnggota',
            'belumCetak',
            'totalLahan',
            'totalPemasukan',
            'totalPinjamanKeluar',
            'pinjamanPending',
            'labels',
            'data',
            'statusCounts'
        ));
    }
}
