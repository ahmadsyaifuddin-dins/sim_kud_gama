<?php

namespace App\Traits\Reports;

use App\Models\Member;
use App\Models\Saving;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait FinanceReportsTrait
{
    public function generateFinanceReport(Request $request, $reportType)
    {
        $activeFilters = [];
        $data = collect();
        $title = '';
        $subtitle = 'Sistem Informasi Manajemen KUD Gajah Mada';
        $view = '';
        $paper = 'portrait';
        $extraData = [];

        // ====================================================================
        // 5. LAPORAN PEMASUKAN PENDAFTARAN
        // ====================================================================
        if ($reportType == 'pendaftaran' || $reportType == 'finance') {
            $query = Member::whereNotNull('file_bukti_bayar');
            
            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
                $activeFilters['Periode Pembayaran'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Pembayaran'] = 'Seluruh Waktu';
            }

            $data = $query->get();
            $extraData['totalPemasukan'] = $data->sum('biaya_pendaftaran');
            
            $title = 'Laporan Pemasukan Biaya Pendaftaran';
            $view = 'reports.pdf_pendaftaran';
            $paper = 'portrait';
        }

        // ====================================================================
        // 6. LAPORAN REKAPITULASI SIMPANAN
        // ====================================================================
        elseif ($reportType == 'rekap_simpanan') {
            $data = Member::with(['savings'])->where('status', 'active')->get()->map(function ($member) {
                $member->total_pokok = $member->savings->where('jenis_simpanan', 'pokok')->sum('jumlah');
                $member->total_wajib = $member->savings->where('jenis_simpanan', 'wajib')->sum('jumlah');
                $member->total_sukarela = $member->savings->where('jenis_simpanan', 'sukarela')->sum('jumlah');
                $member->total_semua = $member->total_pokok + $member->total_wajib + $member->total_sukarela;
                return $member;
            });

            $activeFilters['Status Keanggotaan'] = 'Hanya Anggota Aktif';
            $activeFilters['Sifat Data'] = 'Akumulasi Saldo Akhir Sampai Saat Ini';

            $title = 'Laporan Rekapitulasi Simpanan Anggota';
            $view = 'reports.pdf_rekap_simpanan';
            $paper = 'landscape';
        }

        // ====================================================================
        // 7. LAPORAN ARUS KAS (CASHFLOW)
        // ====================================================================
        elseif ($reportType == 'cashflow') {
            $startDate = $request->start_date ?? '2000-01-01';
            $endDate = $request->end_date ?? now()->format('Y-m-d');

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $activeFilters['Periode Transaksi'] = Carbon::parse($startDate)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($endDate)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Transaksi'] = 'Seluruh Waktu (Keseluruhan)';
            }

            $pendaftaranMasuk = Member::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('biaya_pendaftaran');
            $simpananMasuk = Saving::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('jumlah');
            $angsuranMasuk = Angsuran::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('jumlah_bayar');

            $pinjamanKeluar = Pinjaman::where('status', 'disetujui')
                ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->sum('jumlah_pinjaman');

            $totalMasuk = $pendaftaranMasuk + $simpananMasuk + $angsuranMasuk;
            $saldoBersih = $totalMasuk - $pinjamanKeluar;

            // Mem-passing hasil perhitungan ke $extraData
            $extraData = [
                'pendaftaranMasuk' => $pendaftaranMasuk,
                'simpananMasuk' => $simpananMasuk,
                'angsuranMasuk' => $angsuranMasuk,
                'pinjamanKeluar' => $pinjamanKeluar,
                'totalMasuk' => $totalMasuk,
                'saldoBersih' => $saldoBersih
            ];

            $title = 'Laporan Arus Kas (Cashflow) KUD';
            $view = 'reports.pdf_cashflow';
            $paper = 'portrait';
        }

        // ====================================================================
        // 8. LAPORAN TRANSAKSI SIMPANAN RINCI
        // ====================================================================
        elseif ($reportType == 'simpanan_rinci') {
            $query = Saving::with('member');

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
                $activeFilters['Periode Setor'] = Carbon::parse($request->start_date)->translatedFormat('d M Y') . ' s/d ' . Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $activeFilters['Periode Setor'] = 'Seluruh Data Transaksi';
            }

            $data = $query->orderBy('tanggal_bayar', 'asc')->get();
            
            $title = 'Laporan Rincian Transaksi Simpanan';
            $view = 'reports.pdf_simpanan_rinci';
            $paper = 'portrait';
        }

        // Jika tipe laporan tidak dikenali di trait ini
        else {
            abort(404, 'Jenis Laporan Keuangan Tidak Ditemukan');
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
            // Khusus Cashflow kita buat manual jumlah barisnya karena ini bentuk rangkuman
            'totalData' => $reportType == 'cashflow' ? 4 : $data->count(),
            'data' => $data,
            'type' => 'keuangan',
            'role' => 'Ketua',
            'qrCodeData' => $qrCodeData // <-- Inject QR Code
        ], $extraData);

        $pdf = Pdf::loadView($view, $payload)
            ->setOption(['isPhpEnabled' => true]);
        return $pdf->setPaper('A4', $paper)->stream('Cetak-' . str_replace(' ', '-', $title) . '.pdf');
    }
}