<?php

namespace App\Traits\Reports;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

trait MemberReportsTrait
{
    public function generateMemberReport(Request $request, $reportType)
    {
        $activeFilters = [];
        $data = collect();
        $title = '';
        $subtitle = 'Sistem Informasi Manajemen KUD Gajah Mada';
        $view = '';
        $paper = 'portrait';
        $extraData = []; // Untuk menangani variabel spesifik (seperti $dataLahan)

        // ====================================================================
        // 1. LAPORAN ANGGOTA TERPADU
        // ====================================================================
        if ($reportType == 'anggota_terpadu') {
            $query = Member::query();
            
            if (!empty($request->dusun) && $request->dusun != 'semua') {
                $query->where('dusun', $request->dusun);
                $activeFilters['Wilayah / Dusun'] = $request->dusun;
            } else {
                $activeFilters['Wilayah / Dusun'] = 'Semua Dusun';
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('tanggal_bergabung', [$request->start_date, $request->end_date]);
                $activeFilters['Periode Bergabung'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Bergabung'] = 'Seluruh Waktu';
            }

            $data = $query->get();
            $title = 'Laporan Data Anggota Terpadu';
            $view = 'reports.pdf_anggota_terpadu';
            $paper = 'landscape';
        }

        // ====================================================================
        // 2. LAPORAN DEMOGRAFI & POTENSI
        // ====================================================================
        elseif ($reportType == 'demografi') {
            $data = Member::where('status', 'active')->get();
            
            $activeFilters['Status Keanggotaan'] = 'Hanya Anggota Aktif';
            $activeFilters['Sifat Data'] = 'Data Berjalan (Real-time)';
            
            $title = 'Laporan Demografi dan Potensi Lahan Anggota';
            $view = 'reports.pdf_demografi';
            $paper = 'landscape';
        }

        // ====================================================================
        // 3. LAPORAN ADMINISTRASI KTA
        // ====================================================================
        elseif ($reportType == 'kta') {
            $query = Member::query();
            
            if (!empty($request->status) && $request->status != 'semua') {
                $query->where('status', $request->status);
                // Translate bahasa status agar rapi di PDF
                $statusList = ['active' => 'Aktif', 'inactive' => 'Pasif', 'stopped' => 'Keluar / Berhenti'];
                $activeFilters['Status Keanggotaan'] = $statusList[$request->status] ?? ucfirst($request->status);
            } else {
                $activeFilters['Status Keanggotaan'] = 'Semua Status';
            }

            if (!empty($request->status_cetak) && $request->status_cetak != 'semua') {
                $statusCetak = $request->status_cetak == 'sudah' ? 1 : 0;
                $query->where('status_cetak', $statusCetak);
                $activeFilters['Status Cetak KTA'] = $request->status_cetak == 'sudah' ? 'Sudah Dicetak' : 'Belum Dicetak';
            } else {
                $activeFilters['Status Cetak KTA'] = 'Semua Status Cetak';
            }

            $data = $query->get();
            $title = 'Laporan Status Administrasi KTA';
            $view = 'reports.pdf_kta';
            $paper = 'portrait';
        }

        // ====================================================================
        // 4. LAPORAN TOTAL LUAS LAHAN PERTANIAN (ANALITIK)
        // ====================================================================
        elseif ($reportType == 'distribusi_lahan') {
            $data = Member::where('status', 'active')
                ->selectRaw('dusun, COUNT(id) as total_anggota, SUM(luasan_lahan) as total_hektar')
                ->groupBy('dusun')
                ->get();

            $activeFilters['Status Keanggotaan'] = 'Hanya Anggota Aktif';
            $activeFilters['Fokus Analisis'] = 'Rekapitulasi Luas Kebun Berdasarkan Dusun';
            
            $title = 'Laporan Total Luas Lahan Pertanian';
            $view = 'reports.pdf_distribusi_lahan';
            $paper = 'portrait';
            
            // Karena view distribusi_lahan sebelumnya pakai variabel $dataLahan, kita passing ke extraData
            $extraData['dataLahan'] = $data;
        }

        // Jika tipe laporan tidak dikenali di trait ini
        else {
            abort(404, 'Jenis Laporan Anggota Tidak Ditemukan');
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
            'qrCodeData' => $qrCodeData // <-- QR Code di-inject di sini!
        ], $extraData);

        $pdf = Pdf::loadView($view, $payload)
        ->setOption(['isPhpEnabled' => true]);
        
        return $pdf->setPaper('A4', $paper)->stream('Cetak-' . str_replace(' ', '-', $title) . '.pdf');
    }
}