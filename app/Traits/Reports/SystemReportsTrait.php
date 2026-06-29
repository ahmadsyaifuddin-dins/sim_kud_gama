<?php

namespace App\Traits\Reports;

use App\Models\Management;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

trait SystemReportsTrait
{
    public function generateSystemReport(Request $request, $reportType)
    {
        $activeFilters = [];
        $data = collect();
        $title = '';
        $subtitle = 'Sistem Informasi Manajemen KUD Gajah Mada';
        $view = '';
        $paper = 'portrait';
        $extraData = [];

        // ====================================================================
        // 14. LAPORAN PENGURUS
        // ====================================================================
        if ($reportType == 'pengurus') {
            $data = Management::where('is_active', 1)->get();
            
            $activeFilters['Status Kepengurusan'] = 'Hanya Pengurus Aktif';
            $activeFilters['Sifat Data'] = 'Data Master KUD';

            $title = 'Daftar Susunan Pengurus KUD Gajah Mada';
            $view = 'reports.pdf_pengurus';
            $paper = 'landscape';
        }

        // ====================================================================
        // 15. LAPORAN HAK AKSES PENGGUNA
        // ====================================================================
        elseif ($reportType == 'pengguna') {
            $data = User::all();
            
            $activeFilters['Cakupan Akses'] = 'Seluruh Akun Terdaftar';
            $activeFilters['Sifat Data'] = 'Data Master Sistem';

            $title = 'Laporan Data Hak Akses Pengguna';
            $view = 'reports.pdf_pengguna';
            $paper = 'portrait';
        }

        // Jika tipe laporan tidak dikenali di trait ini
        else {
            abort(404, 'Jenis Laporan Sistem Tidak Ditemukan');
        }

        // ====================================================================
        // GENERATE TOKEN & BUNGKUS PAYLOAD UNTUK RENDER PDF
        // ====================================================================
        
        // 1. Buat token unik (Gabungan Tipe Laporan dan Waktu Cetak)
        $validationToken = base64_encode($reportType . '|' . now()->timestamp);
        
        // 2. Buat URL QR Code
        $qrCodeData = route('validasi.dokumen', ['token' => $validationToken]);

        $payload = array_merge([
            'title' => $title,
            'subtitle' => $subtitle,
            'activeFilters' => $activeFilters,
            'totalData' => $data->count(),
            'data' => $data,
            'qrCodeData' => $qrCodeData // <-- Inject QR Code
        ], $extraData);

        $pdf = Pdf::loadView($view, $payload)
        ->setOption(['isPhpEnabled' => true]);
        return $pdf->setPaper('A4', $paper)->stream('Cetak-' . str_replace(' ', '-', $title) . '.pdf');
    }
}