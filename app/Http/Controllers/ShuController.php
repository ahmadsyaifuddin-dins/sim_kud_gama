<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShuRequest;
use App\Models\ShuDistribution;
use App\Models\ShuMemberDistribution;
use App\Services\ShuCalculator;
use App\Support\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShuController extends Controller
{
    /**
     * Daftar riwayat pembagian SHU.
     */
    public function index()
    {
        $distributions = ShuDistribution::with('creator')->latest()->get();

        return view('shu.index', compact('distributions'));
    }

    /**
     * Form persiapan kalkulasi SHU.
     */
    public function create()
    {
        $years = ShuCalculator::availableYears();
        $distributedKeys = ShuDistribution::pluck('period_key')->flip();

        $availableYears = collect($years)
            ->reject(fn ($year) => $distributedKeys->has($year))
            ->values()
            ->all();

        $defaults = [
            'jasa_modal_persen' => (float) Setting::get('shu_jasa_modal_persen', 35),
            'jasa_transaksi_persen' => (float) Setting::get('shu_jasa_transaksi_persen', 40),
            'cadangan_persen' => (float) Setting::get('shu_cadangan_persen', 25),
        ];

        return view('shu.create', compact('availableYears', 'defaults'));
    }

    /**
     * Jalankan kalkulasi & simpan pembagian SHU.
     */
    public function store(ShuRequest $request)
    {
        $validated = $request->validated();

        $year = (int) $validated['tahun'];
        $totalShu = (float) $validated['total_shu'];
        $jasaModalPersen = (float) $validated['jasa_modal_persen'];
        $jasaTransaksiPersen = (float) $validated['jasa_transaksi_persen'];
        $cadanganPersen = (float) $validated['cadangan_persen'];

        $duplicate = ShuDistribution::where('period_key', (string) $year)->exists();
        if ($duplicate) {
            return back()->withErrors(['tahun' => "Pembagian SHU untuk tahun {$year} sudah pernah dikalkulasi."]);
        }

        $calc = ShuCalculator::distribute($year, $totalShu, $jasaModalPersen, $jasaTransaksiPersen, $cadanganPersen);

        if ($calc['summary']['total_member'] === 0) {
            return back()->withErrors(['tahun' => 'Tidak ada data anggota yang memenuhi syarat untuk periode tersebut.']);
        }

        try {
            $distribution = DB::transaction(function () use (
                $year,
                $totalShu,
                $jasaModalPersen,
                $jasaTransaksiPersen,
                $cadanganPersen,
                $calc,
                $validated
            ) {
                $dist = ShuDistribution::create([
                    'period_key' => (string) $year,
                    'label' => 'Tahun Buku '.$year,
                    'total_shu' => $totalShu,
                    'jasa_modal_persen' => $jasaModalPersen,
                    'jasa_transaksi_persen' => $jasaTransaksiPersen,
                    'cadangan_persen' => $cadanganPersen,
                    'total_jasa_modal' => round($calc['summary']['jasa_modal_pool'], 2),
                    'total_jasa_transaksi' => round($calc['summary']['jasa_transaksi_pool'], 2),
                    'total_cadangan' => round($calc['summary']['total_cadangan'], 2),
                    'total_member' => $calc['summary']['total_member'],
                    'created_by' => Auth::id(),
                    'calculated_at' => now(),
                    'note' => $validated['note'] ?? null,
                ]);

                foreach ($calc['rows'] as $row) {
                    ShuMemberDistribution::create([
                        'shu_distribution_id' => $dist->id,
                        'member_id' => $row->member_id,
                        'saldo_simpanan' => $row->saldo_simpanan,
                        'jasa_modal' => $row->jasa_modal,
                        'total_transaksi' => $row->total_transaksi,
                        'jasa_transaksi' => $row->jasa_transaksi,
                        'total_shu' => $row->total_shu,
                    ]);
                }

                return $dist;
            });
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kalkulasi SHU: '.$e->getMessage()]);
        }

        return redirect()->route('shu.show', $distribution->id)
            ->with('success', 'Kalkulasi SHU tahun '.$year.' berhasil diproses.');
    }

    /**
     * Detail rincian pembagian SHU per anggota.
     */
    public function show(ShuDistribution $distribution)
    {
        $distribution->load(['memberDistributions.member', 'creator']);

        return view('shu.show', compact('distribution'));
    }

    /**
     * Cetak PDF rincian pembagian SHU.
     */
    public function exportPdf(ShuDistribution $distribution)
    {
        $distribution->load(['memberDistributions.member', 'creator']);

        $totalDibagikan = (float) $distribution->total_jasa_modal + (float) $distribution->total_jasa_transaksi;

        $payload = [
            'title' => 'Laporan Pembagian SHU',
            'subtitle' => 'Sistem Informasi Manajemen KUD Gajah Mada',
            'totalData' => $distribution->total_member,
            'activeFilters' => [
                'Periode' => $distribution->label,
                'Alokasi Jasa Modal' => number_format($distribution->jasa_modal_persen, 1, ',', '.').'%',
                'Alokasi Jasa Transaksi' => number_format($distribution->jasa_transaksi_persen, 1, ',', '.').'%',
                'Alokasi Cadangan' => number_format($distribution->cadangan_persen, 1, ',', '.').'%',
            ],
            'type' => 'keuangan',
            'role' => 'Ketua',
            'distribution' => $distribution,
            'rows' => $distribution->memberDistributions,
            'totalDibagikan' => $totalDibagikan,
        ];

        $pdf = Pdf::loadView('shu.pdf_shu', $payload)->setOption(['isPhpEnabled' => true]);

        return $pdf->setPaper('A4', 'landscape')
            ->stream('Laporan-Pembagian-SHU-'.$distribution->period_key.'.pdf');
    }
}