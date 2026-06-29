<?php

namespace App\Traits\Reports;

use App\Models\Pinjaman;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait LoanReportsTrait
{
    public function generateLoanReport(Request $request, $reportType)
    {
        $activeFilters = [];
        $data = collect();
        $title = '';
        $subtitle = 'Sistem Informasi Manajemen KUD Gajah Mada';
        $view = '';
        $paper = 'portrait';
        $extraData = []; // Untuk variabel tambahan seperti total nominal

        // ====================================================================
        // 9. LAPORAN REKAP PINJAMAN
        // ====================================================================
        if ($reportType == 'pinjaman_rekap') {
            $query = Pinjaman::with('member');
            
            if (!empty($request->status_pinjaman) && $request->status_pinjaman != 'semua') {
                $query->where('status', $request->status_pinjaman);
                $activeFilters['Status Pengajuan'] = ucfirst($request->status_pinjaman);
            } else {
                $activeFilters['Status Pengajuan'] = 'Semua Status';
            }

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal_pengajuan', [$request->start_date, $request->end_date]);
                $activeFilters['Periode Pengajuan'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Pengajuan'] = 'Seluruh Waktu';
            }

            $data = $query->latest()->get();
            $title = 'Laporan Rekapitulasi Pengajuan Pinjaman';
            $view = 'reports.pdf_pinjaman_rekap';
            $paper = 'landscape';
        }

        // ====================================================================
        // 10. LAPORAN PINJAMAN BELUM LUNAS (TUNGGAKAN)
        // ====================================================================
        elseif ($reportType == 'pinjaman_tunggakan') {
            $data = Pinjaman::with('member')->where('status', 'disetujui')->get();
            
            $activeFilters['Status Pinjaman'] = 'Disetujui (Dalam Masa Angsuran)';
            $activeFilters['Sifat Data'] = 'Data Berjalan (Real-time)';
            
            $title = 'Laporan Pinjaman Anggota Belum Lunas';
            $view = 'reports.pdf_pinjaman_tunggakan';
            $paper = 'portrait';
        }

        // ====================================================================
        // 11. LAPORAN KOLEKTIBILITAS (STATUS KELANCARAN)
        // ====================================================================
        elseif ($reportType == 'kolektibilitas') {
            $data = Pinjaman::with(['member', 'angsuran'])
                ->whereIn('status', ['disetujui', 'lunas'])
                ->get()
                ->map(function ($pinjaman) {
                    $pinjaman->total_terbayar = $pinjaman->angsuran->sum('jumlah_bayar');
                    $pinjaman->sisa_hutang = $pinjaman->jumlah_pinjaman - $pinjaman->total_terbayar;

                    if ($pinjaman->sisa_hutang <= 0) {
                        $pinjaman->kolektibilitas = 'Lunas';
                    } elseif ($pinjaman->angsuran->count() == 0 && now()->diffInDays($pinjaman->updated_at) > 30) {
                        $pinjaman->kolektibilitas = 'Macet (Belum Ada Bayaran)';
                    } else {
                        $pinjaman->kolektibilitas = 'Dalam Angsuran';
                    }

                    return $pinjaman;
                });

            $activeFilters['Fokus Analisis'] = 'Monitoring Kelancaran Bayar & Sisa Hutang';
            $activeFilters['Sifat Data'] = 'Data Akumulatif Sampai Saat Ini';
            
            $title = 'Laporan Kolektibilitas & Sisa Hutang Pinjaman';
            $view = 'reports.pdf_kolektibilitas';
            $paper = 'landscape';
        }

        // ====================================================================
        // 12. LAPORAN ANGSURAN MASUK
        // ====================================================================
        elseif ($reportType == 'angsuran_masuk') {
            $query = Angsuran::with('pinjaman.member');
            
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
                $activeFilters['Periode Pembayaran'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Pembayaran'] = 'Seluruh Waktu';
            }

            $data = $query->orderBy('tanggal_bayar', 'asc')->get();
            $extraData['totalAngsuran'] = $data->sum('jumlah_bayar');
            
            $title = 'Laporan Pemasukan Angsuran Anggota';
            $view = 'reports.pdf_angsuran_masuk';
            $paper = 'portrait';
        }

        // ====================================================================
        // 13. LAPORAN REALISASI PENCAIRAN DANA
        // ====================================================================
        elseif ($reportType == 'realisasi_pencairan') {
            $query = Pinjaman::with('member')->whereIn('status', ['disetujui', 'lunas']);

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('updated_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
                $activeFilters['Periode Pencairan'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Pencairan'] = 'Seluruh Data Pencairan';
            }

            $data = $query->orderBy('updated_at', 'asc')->get();
            
            $title = 'Laporan Realisasi Pencairan Dana Pinjaman';
            $view = 'reports.pdf_realisasi_pencairan';
            $paper = 'landscape';
        }

        // Jika tipe laporan tidak dikenali di trait ini
        else {
            abort(404, 'Jenis Laporan Pinjaman Tidak Ditemukan');
        }

        // ====================================================================
        // BUNGKUS PAYLOAD DAN RENDER PDF
        // ====================================================================
        $payload = array_merge([
            'title' => $title,
            'subtitle' => $subtitle,
            'activeFilters' => $activeFilters,
            'totalData' => $data->count(),
            'data' => $data,
            'type' => 'keuangan',
            'role' => 'Ketua'
        ], $extraData);

        $pdf = Pdf::loadView($view, $payload)
        ->setOption(['isPhpEnabled' => true]);
        return $pdf->setPaper('A4', $paper)->stream('Cetak-' . str_replace(' ', '-', $title) . '.pdf');
    }
}