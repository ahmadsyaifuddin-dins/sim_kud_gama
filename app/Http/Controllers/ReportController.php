<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Models\Angsuran;
use App\Models\Management;
use App\Models\Member;
use App\Models\Pinjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $dusunList = Member::select('dusun')->distinct()->pluck('dusun');

        return view('reports.index', compact('dusunList'));
    }

    public function export(Request $request)
    {
        $filters = $this->getFilters($request);

        if ($request->action == 'excel') {
            return $this->downloadExcel($filters);
        } elseif ($request->action == 'pdf') {
            return $this->downloadPdf($request, $filters);
        }

        return back()->with('error', 'Format laporan tidak dikenali.');
    }

    private function getFilters(Request $request)
    {
        return [
            'report_type' => $request->report_type ?? 'general',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'dusun' => $request->dusun,
            'status_cetak' => $request->status_cetak,
            'status' => $request->status,
        ];
    }

    private function getFilteredQuery(array $filters)
    {
        $query = Member::query();

        // 1. LOGIKA KEUANGAN (Tetap sama)
        if ($filters['report_type'] == 'finance') {
            $query->whereNotNull('file_bukti_bayar');
            if ($filters['start_date'] && $filters['end_date']) {
                $query->whereBetween('tanggal_bayar', [$filters['start_date'], $filters['end_date']]);
            }
        }

        // 2. LOGIKA LAPORAN STATUS (BARU)
        elseif ($filters['report_type'] == 'status') {
            // Jika user memilih filter status spesifik (bukan 'semua')
            if (! empty($filters['status']) && $filters['status'] != 'semua') {
                $query->where('status', $filters['status']);
            }
        }

        // 3. LOGIKA UMUM (Tetap sama)
        else {
            if ($filters['start_date'] && $filters['end_date']) {
                $query->whereBetween('tanggal_bergabung', [$filters['start_date'], $filters['end_date']]);
            }
            if (! empty($filters['dusun']) && $filters['dusun'] != 'semua') {
                $query->where('dusun', $filters['dusun']);
            }
            if (! empty($filters['status_cetak']) && $filters['status_cetak'] != 'semua') {
                $status = $filters['status_cetak'] == 'sudah' ? 1 : 0;
                $query->where('status_cetak', $status);
            }
        }

        return $query;
    }

    private function downloadExcel(array $filters)
    {
        $prefix = ($filters['report_type'] == 'finance') ? 'Laporan-Keuangan-' : 'Laporan-Anggota-';
        $filename = $prefix.now()->format('Y-m-d').'.xlsx';

        return Excel::download(new MemberExport($filters), $filename);
    }

    private function downloadPdf(Request $request, array $filters)
    {
        // Ambil tipe laporan, defaultnya 'general' jika form tidak mengirim report_type
        $reportType = $filters['report_type'] ?? 'general';

        // 1. LAPORAN KEUANGAN
        if ($reportType == 'finance') {
            $members = $this->getFilteredQuery($filters)->get();
            $data = [
                'members' => $members,
                'totalPemasukan' => $members->sum('biaya_pendaftaran'),
                'request' => $request,
            ];
            $pdf = Pdf::loadView('reports.finance_pdf', $data);

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Keuangan.pdf');
        }

        // 2. LAPORAN STATUS KEANGGOTAAN
        if ($reportType == 'status') {
            $members = $this->getFilteredQuery($filters)->get();
            $title = 'Laporan Status Keanggotaan';

            if (empty($filters['status']) || $filters['status'] == 'semua') {
                $subtitle = 'Semua Status (Aktif, Pasif, Berhenti, Pending)';
            } else {
                $statusMap = [
                    'active' => 'ANGGOTA AKTIF',
                    'inactive' => 'PASIF / NON-AKTIF',
                    'stopped' => 'BERHENTI / KELUAR',
                    'pending' => 'PENDING (Menunggu Verifikasi)',
                ];
                $subtitle = 'Status: '.($statusMap[$filters['status']] ?? strtoupper($filters['status']));
            }

            $pdf = Pdf::loadView('reports.pdf_status_anggota', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Status-Anggota.pdf');
        }

        // 3. LAPORAN REKAP PINJAMAN
        if ($reportType == 'pinjaman_rekap') {
            $query = Pinjaman::with('member');

            if (! empty($request->status_pinjaman) && $request->status_pinjaman != 'semua') {
                $query->where('status', $request->status_pinjaman);
            }
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('tanggal_pengajuan', [$request->start_date, $request->end_date]);
            }

            $data = $query->latest()->get();
            $title = 'Laporan Rekapitulasi Pengajuan Pinjaman';
            $subtitle = 'Filter: '.($request->status_pinjaman == 'semua' ? 'Semua Status' : ucfirst($request->status_pinjaman));

            $pdf = Pdf::loadView('reports.pdf_pinjaman_rekap', compact('data', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Pinjaman.pdf');
        }

        // 4. LAPORAN PINJAMAN BELUM LUNAS (TUNGGAKAN)
        if ($reportType == 'pinjaman_tunggakan') {
            $data = Pinjaman::with('member')->where('status', 'disetujui')->get();
            $title = 'Laporan Pinjaman Anggota Belum Lunas';
            $subtitle = 'Status: Disetujui (Dalam Masa Angsuran)';

            $pdf = Pdf::loadView('reports.pdf_pinjaman_tunggakan', compact('data', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Pinjaman-Belum-Lunas.pdf');
        }

        // 5. LAPORAN ANGSURAN MASUK
        if ($reportType == 'angsuran_masuk') {
            $query = Angsuran::with('pinjaman.member');
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
            }
            $data = $query->orderBy('tanggal_bayar', 'asc')->get();
            $totalAngsuran = $data->sum('jumlah_bayar');

            $title = 'Laporan Pemasukan Angsuran Anggota';
            $subtitle = 'Periode Bayar: '.\Carbon\Carbon::parse($request->start_date)->translatedFormat('d M Y').' s/d '.\Carbon\Carbon::parse($request->end_date)->translatedFormat('d M Y');

            $pdf = Pdf::loadView('reports.pdf_angsuran_masuk', compact('data', 'title', 'subtitle', 'totalAngsuran'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Angsuran-Masuk.pdf');
        }

        // 6. LAPORAN PENGURUS
        if ($reportType == 'pengurus') {
            $data = Management::where('is_active', 1)->get();
            $title = 'Daftar Susunan Pengurus KUD Gajah Mada';
            $subtitle = 'Periode Aktif';

            $pdf = Pdf::loadView('reports.pdf_pengurus', compact('data', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Pengurus.pdf');
        }

        // ====================================================================
        // 7. KELOMPOK LAPORAN UMUM (General) - Menggunakan data $members
        // ====================================================================
        $members = $this->getFilteredQuery($filters)->get();

        // 7A. LAPORAN PER WILAYAH
        if (! empty($filters['dusun'])) {
            $title = 'Laporan Anggota Per Wilayah';
            $subtitle = $filters['dusun'] == 'semua' ? 'Semua Dusun' : 'Dusun: '.$filters['dusun'];
            $pdf = Pdf::loadView('reports.pdf_anggota_wilayah', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Wilayah.pdf');
        }

        // 7B. LAPORAN STATUS CETAK KTA
        if (! empty($filters['status_cetak'])) {
            $title = 'Laporan Status Pencetakan Kartu (KTA)';
            if ($filters['status_cetak'] == 'semua') {
                $subtitle = 'Semua Status Cetak';
            } else {
                $status = ($filters['status_cetak'] == 'sudah') ? 'SUDAH DICETAK' : 'BELUM DICETAK';
                $subtitle = "Filter: $status";
            }
            $pdf = Pdf::loadView('reports.pdf_status_cetak', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Status-Cetak.pdf');
        }

        // 7C. LAPORAN PER PERIODE BERGABUNG
        if (! empty($filters['start_date']) && ! empty($filters['end_date'])) {
            $title = 'Laporan Anggota Per Periode';
            $tglAwal = \Carbon\Carbon::parse($filters['start_date'])->translatedFormat('d F Y');
            $tglAkhir = \Carbon\Carbon::parse($filters['end_date'])->translatedFormat('d F Y');
            $subtitle = "Periode Gabung: $tglAwal s/d $tglAkhir";
            $pdf = Pdf::loadView('reports.pdf_anggota_periode', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Periode.pdf');
        }

        // 7D. DEFAULT: LAPORAN SELURUH ANGGOTA
        $title = 'Laporan Seluruh Anggota';
        $subtitle = 'Semua Data';
        $pdf = Pdf::loadView('reports.pdf_anggota_semua', compact('members', 'title', 'subtitle'));

        return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Seluruh-Anggota.pdf');
    }
}
