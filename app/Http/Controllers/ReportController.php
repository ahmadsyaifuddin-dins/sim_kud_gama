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
        $reportType = $filters['report_type'] ?? 'general';

        // ====================================================================
        // A. KELOMPOK DATA ANGGOTA & ADMINISTRASI
        // ====================================================================

        // 1. LAPORAN ANGGOTA TERPADU
        if ($reportType == 'anggota_terpadu') {
            $query = Member::query();
            if (! empty($request->dusun) && $request->dusun != 'semua') {
                $query->where('dusun', $request->dusun);
            }
            if (! empty($request->start_date) && ! empty($request->end_date)) {
                $query->whereBetween('tanggal_bergabung', [$request->start_date, $request->end_date]);
            }

            $members = $query->get();
            $title = 'Laporan Data Anggota Terpadu';
            $subtitle = 'Filter: '.($request->dusun == 'semua' ? 'Semua Wilayah' : 'Wilayah '.$request->dusun);

            $pdf = Pdf::loadView('reports.pdf_anggota_terpadu', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Anggota-Terpadu.pdf');
        }

        // 2. LAPORAN DEMOGRAFI & POTENSI
        if ($reportType == 'demografi') {
            $members = Member::where('status', 'active')->get();
            $title = 'Laporan Demografi dan Potensi Lahan Anggota';
            $subtitle = 'Data Seluruh Anggota Aktif KUD Gajah Mada';

            $pdf = Pdf::loadView('reports.pdf_demografi', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Demografi.pdf');
        }

        // 3. LAPORAN ADMINISTRASI KTA
        if ($reportType == 'kta') {
            $query = Member::query();
            if (! empty($request->status) && $request->status != 'semua') {
                $query->where('status', $request->status);
            }
            if (! empty($request->status_cetak) && $request->status_cetak != 'semua') {
                $statusCetak = $request->status_cetak == 'sudah' ? 1 : 0;
                $query->where('status_cetak', $statusCetak);
            }

            $members = $query->get();
            $title = 'Laporan Status Administrasi KTA';
            $subtitle = 'Monitoring Pencetakan Kartu Tanda Anggota';

            $pdf = Pdf::loadView('reports.pdf_kta', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Administrasi-KTA.pdf');
        }

        // ====================================================================
        // B. KELOMPOK KEUANGAN & SIMPANAN
        // ====================================================================

        // 4. LAPORAN PEMASUKAN PENDAFTARAN (Dulu 'finance')
        if ($reportType == 'pendaftaran' || $reportType == 'finance') {
            $query = Member::whereNotNull('file_bukti_bayar');
            if (! empty($request->start_date) && ! empty($request->end_date)) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
            }

            $members = $query->get();
            $totalPemasukan = $members->sum('biaya_pendaftaran');

            $title = 'Laporan Pemasukan Biaya Pendaftaran';
            $subtitle = 'Pendaftaran Keanggotaan Baru';

            $pdf = Pdf::loadView('reports.pdf_pendaftaran', compact('members', 'totalPemasukan', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Pemasukan-Pendaftaran.pdf');
        }

        // 5. LAPORAN REKAPITULASI SIMPANAN
        if ($reportType == 'rekap_simpanan') {
            $members = Member::with(['savings'])->where('status', 'active')->get()->map(function ($member) {
                $member->total_pokok = $member->savings->where('jenis_simpanan', 'pokok')->sum('jumlah');
                $member->total_wajib = $member->savings->where('jenis_simpanan', 'wajib')->sum('jumlah');
                $member->total_sukarela = $member->savings->where('jenis_simpanan', 'sukarela')->sum('jumlah');
                $member->total_semua = $member->total_pokok + $member->total_wajib + $member->total_sukarela;

                return $member;
            });

            $title = 'Laporan Rekapitulasi Simpanan Anggota';
            $subtitle = 'Periode: Sampai Saat Ini';

            $pdf = Pdf::loadView('reports.pdf_rekap_simpanan', compact('members', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Simpanan.pdf');
        }

        // 6. LAPORAN ARUS KAS (CASHFLOW)
        if ($reportType == 'cashflow') {
            $startDate = $request->start_date ?? '2000-01-01';
            $endDate = $request->end_date ?? now()->format('Y-m-d');

            $pendaftaranMasuk = Member::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('biaya_pendaftaran');
            $simpananMasuk = \App\Models\Saving::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('jumlah');
            $angsuranMasuk = Angsuran::whereBetween('tanggal_bayar', [$startDate, $endDate])->sum('jumlah_bayar');

            $pinjamanKeluar = Pinjaman::where('status', 'disetujui')
                ->whereBetween('updated_at', [$startDate.' 00:00:00', $endDate.' 23:59:59'])
                ->sum('jumlah_pinjaman');

            $totalMasuk = $pendaftaranMasuk + $simpananMasuk + $angsuranMasuk;
            $saldoBersih = $totalMasuk - $pinjamanKeluar;

            $title = 'Laporan Arus Kas (Cashflow) KUD';
            $subtitle = 'Periode: '.\Carbon\Carbon::parse($startDate)->translatedFormat('d M Y').' s/d '.\Carbon\Carbon::parse($endDate)->translatedFormat('d M Y');

            $data = compact('pendaftaranMasuk', 'simpananMasuk', 'angsuranMasuk', 'totalMasuk', 'pinjamanKeluar', 'saldoBersih', 'title', 'subtitle');
            $pdf = Pdf::loadView('reports.pdf_cashflow', $data);

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Arus-Kas.pdf');
        }

        // ====================================================================
        // C. KELOMPOK PINJAMAN & KREDIT
        // ====================================================================

        // 7. LAPORAN REKAP PINJAMAN
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

        // 8. LAPORAN PINJAMAN BELUM LUNAS (TUNGGAKAN)
        if ($reportType == 'pinjaman_tunggakan') {
            $data = Pinjaman::with('member')->where('status', 'disetujui')->get();
            $title = 'Laporan Pinjaman Anggota Belum Lunas';
            $subtitle = 'Status: Disetujui (Dalam Masa Angsuran)';

            $pdf = Pdf::loadView('reports.pdf_pinjaman_tunggakan', compact('data', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Pinjaman-Belum-Lunas.pdf');
        }

        // 9. LAPORAN KOLEKTIBILITAS (STATUS KELANCARAN)
        if ($reportType == 'kolektibilitas') {
            $pinjamans = Pinjaman::with(['member', 'angsuran'])->whereIn('status', ['disetujui', 'lunas'])->get()->map(function ($pinjaman) {
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

            $title = 'Laporan Kolektibilitas & Sisa Hutang Pinjaman';
            $subtitle = 'Monitoring Kelancaran Kredit Anggota';

            $pdf = Pdf::loadView('reports.pdf_kolektibilitas', compact('pinjamans', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Kolektibilitas.pdf');
        }

        // 10. LAPORAN ANGSURAN MASUK
        if ($reportType == 'angsuran_masuk') {
            $query = Angsuran::with('pinjaman.member');
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
                $subtitle = 'Periode Bayar: '.\Carbon\Carbon::parse($request->start_date)->translatedFormat('d M Y').' s/d '.\Carbon\Carbon::parse($request->end_date)->translatedFormat('d M Y');
            } else {
                $subtitle = 'Periode Bayar: Seluruh Data (Semua Waktu)';
            }

            $data = $query->orderBy('tanggal_bayar', 'asc')->get();
            $totalAngsuran = $data->sum('jumlah_bayar');
            $title = 'Laporan Pemasukan Angsuran Anggota';

            $pdf = Pdf::loadView('reports.pdf_angsuran_masuk', compact('data', 'title', 'subtitle', 'totalAngsuran'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Angsuran-Masuk.pdf');
        }

        // ====================================================================
        // D. KELOMPOK SISTEM & MANAJEMEN
        // ====================================================================

        // 11. LAPORAN PENGURUS
        if ($reportType == 'pengurus') {
            $data = Management::where('is_active', 1)->get();
            $title = 'Daftar Susunan Pengurus KUD Gajah Mada';
            $subtitle = 'Periode Aktif';

            $pdf = Pdf::loadView('reports.pdf_pengurus', compact('data', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'landscape')->stream('Laporan-Pengurus.pdf');
        }

        // 12. LAPORAN HAK AKSES PENGGUNA
        if ($reportType == 'pengguna') {
            $users = \App\Models\User::all();
            $title = 'Laporan Data Hak Akses Pengguna';
            $subtitle = 'Sistem Informasi Manajemen KUD Gajah Mada';

            $pdf = Pdf::loadView('reports.pdf_pengguna', compact('users', 'title', 'subtitle'));

            return $pdf->setPaper('A4', 'portrait')->stream('Laporan-Pengguna.pdf');
        }

        // DEFAULT FALLBACK JIKA ADA ERROR PARAMETER
        return back()->with('error', 'Jenis Laporan Tidak Ditemukan.');
    }
}
