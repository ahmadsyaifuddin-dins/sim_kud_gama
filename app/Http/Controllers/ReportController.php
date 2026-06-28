<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Exports\MemberExport;
use Maatwebsite\Excel\Facades\Excel;

// Mengimpor Traits yang sudah kita buat sebelumnya
use App\Traits\Reports\MemberReportsTrait;
use App\Traits\Reports\FinanceReportsTrait;
use App\Traits\Reports\LoanReportsTrait;
use App\Traits\Reports\SystemReportsTrait;

class ReportController extends Controller
{
    /**
     * Menggunakan Traits untuk menjaga Controller tetap ramping.
     * Prinsip DRY (Don't Repeat Yourself) dan SRP (Single Responsibility Principle)
     * sangat terjaga dengan pemisahan domain laporan seperti ini.
     */
    use MemberReportsTrait, FinanceReportsTrait, LoanReportsTrait, SystemReportsTrait;

    /**
     * Menampilkan halaman antarmuka Laporan.
     */
    public function index()
    {
        // Mengambil daftar dusun yang unik, memastikan tidak ada yang null atau duplikat
        $dusunList = Member::select('dusun')->whereNotNull('dusun')->distinct()->pluck('dusun');
        
        return view('reports.index', compact('dusunList'));
    }

    /**
     * Memproses rute export dan bertindak sebagai "Traffic Controller".
     * Tidak ada logika bisnis di sini, hanya mengarahkan request ke Trait/Class yang tepat.
     */
    public function export(Request $request)
    {
        $type = $request->report_type;

        // 1. PENANGANAN EXPORT PDF (Menggunakan Match Expression PHP 8 yang lebih bersih dari Switch-Case)
        if ($request->action == 'pdf') {
            return match (true) {
                // A. Kelompok Anggota & Administrasi
                in_array($type, ['anggota_terpadu', 'demografi', 'kta', 'distribusi_lahan']) 
                    => $this->generateMemberReport($request, $type),
                
                // B. Kelompok Keuangan & Simpanan
                in_array($type, ['pendaftaran', 'rekap_simpanan', 'cashflow', 'simpanan_rinci']) 
                    => $this->generateFinanceReport($request, $type),
                
                // C. Kelompok Pinjaman & Kredit
                in_array($type, ['pinjaman_rekap', 'pinjaman_tunggakan', 'kolektibilitas', 'angsuran_masuk', 'realisasi_pencairan']) 
                    => $this->generateLoanReport($request, $type),
                
                // D. Kelompok Sistem & Data Master
                in_array($type, ['pengurus', 'pengguna']) 
                    => $this->generateSystemReport($request, $type),
                
                // Fallback / Keamanan
                default => back()->with('error', 'Jenis Laporan PDF tidak dikenali atau terjadi kesalahan parameter.')
            };
        }

        // 2. PENANGANAN EXPORT EXCEL
        if ($request->action == 'excel') {
            return $this->downloadExcel($request);
        }

        return back()->with('error', 'Aksi tidak valid. Silakan pilih tombol Cetak PDF atau Export Excel.');
    }

    /**
     * Logika terpusat untuk mengunduh Excel.
     */
    private function downloadExcel(Request $request)
    {
        $filters = $request->all();
        
        // Penamaan file dinamis berdasarkan kelompok laporan
        $prefix = in_array($request->report_type, ['pendaftaran', 'rekap_simpanan', 'cashflow', 'simpanan_rinci']) 
            ? 'Laporan-Keuangan-' 
            : 'Laporan-Data-KUD-';
            
        // Penamaan menggunakan penanggalan format Indonesia
        $filename = $prefix . now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new MemberExport($filters), $filename);
    }
}