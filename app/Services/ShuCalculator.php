<?php

namespace App\Services;

use App\Models\Angsuran;
use App\Models\Saving;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShuCalculator
{
    /**
     * Hitung pembagian SHU untuk satu tahun buku.
     *
     * Alokasi SHU:
     *  - Jasa Usaha / Modal   : proporsional terhadap akumulasi simpanan anggota (s/d akhir periode).
     *  - Jasa Transaksi       : proporsional terhadap keaktifan perputaran transaksi
     *                           (angsuran terbayar + simpanan disetor) dalam periode.
     *  - Cadangan             : sisanya untuk cadangan koperasi (tidak dibagikan ke anggota).
     *
     * @return array{rows: \Illuminate\Support\Collection, summary: array}
     */
    public static function distribute(
        int $year,
        float $totalShu,
        float $jasaModalPersen,
        float $jasaTransaksiPersen,
        float $cadanganPersen,
        ?int $memberStatusAuditTahun = null
    ) {
        $start = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $end = $start->copy()->endOfYear();
        $startDate = $start->format('Y-m-d');
        $endDate = $end->format('Y-m-d');

        // 1. Akumulasi saldo simpanan tiap anggota s/d akhir periode (modal)
        $saldoSimpanan = Saving::query()
            ->selectRaw('member_id, SUM(jumlah) as total')
            ->where('tanggal_bayar', '<=', $endDate)
            ->groupBy('member_id')
            ->pluck('total', 'member_id');

        // 2. Akumulasi transaksi tiap anggota dalam periode (simpanan disetor)
        $transaksi = [];
        $simpananDalamPeriode = Saving::query()
            ->selectRaw('member_id, SUM(jumlah) as total')
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->groupBy('member_id')
            ->get();

        foreach ($simpananDalamPeriode as $row) {
            $transaksi[$row->member_id] = (float) $row->total;
        }

        // 3. Akumulasi transaksi angsuran terbayar dalam periode (via tabel pinjaman)
        $angsuranDalamPeriode = Angsuran::query()
            ->join('pinjaman', 'pinjaman.id', '=', 'angsuran.pinjaman_id')
            ->whereBetween('angsuran.tanggal_bayar', [$startDate, $endDate])
            ->selectRaw('pinjaman.member_id, SUM(angsuran.jumlah_bayar) as total')
            ->groupBy('pinjaman.member_id')
            ->get();

        foreach ($angsuranDalamPeriode as $row) {
            $transaksi[$row->member_id] = ($transaksi[$row->member_id] ?? 0) + (float) $row->total;
        }

        $totalModal = (float) $saldoSimpanan->sum();
        $totalTransaksi = array_sum($transaksi);

        $jasaModalPool = $totalShu * ($jasaModalPersen / 100);
        $jasaTransaksiPool = $totalShu * ($jasaTransaksiPersen / 100);
        $totalCadangan = $totalShu * ($cadanganPersen / 100);

        // 4. Gabungan anggota yang berhak (punya saldo simpanan ATAU transaksi)
        $memberIds = collect($saldoSimpanan->keys())
            ->merge(array_keys($transaksi))
            ->unique()
            ->values();

        $rows = collect([]);

        foreach ($memberIds as $memberId) {
            $modal = (float) ($saldoSimpanan[$memberId] ?? 0);
            $trans = (float) ($transaksi[$memberId] ?? 0);

            if ($modal <= 0 && $trans <= 0) {
                continue;
            }

            $jasaModal = $totalModal > 0 ? ($modal / $totalModal) * $jasaModalPool : 0;
            $jasaTransaksi = $totalTransaksi > 0 ? ($trans / $totalTransaksi) * $jasaTransaksiPool : 0;

            $rows->push((object) [
                'member_id' => $memberId,
                'saldo_simpanan' => round($modal, 2),
                'jasa_modal' => round($jasaModal, 2),
                'total_transaksi' => round($trans, 2),
                'jasa_transaksi' => round($jasaTransaksi, 2),
                'total_shu' => round($jasaModal + $jasaTransaksi, 2),
            ]);
        }

        $rows = $rows->sortByDesc('total_shu')->values();

        $summary = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_modal' => $totalModal,
            'total_transaksi' => $totalTransaksi,
            'jasa_modal_pool' => $jasaModalPool,
            'jasa_transaksi_pool' => $jasaTransaksiPool,
            'total_cadangan' => $totalCadangan,
            'total_dibagikan' => round($rows->sum('total_shu'), 2),
            'total_member' => $rows->count(),
        ];

        return ['rows' => $rows, 'summary' => $summary];
    }

    /**
     * Tahun-tahun yang memuat transaksi (untuk pilihan periode kalkulasi SHU).
     *
     * @return array<int, string>
     */
    public static function availableYears(): array
    {
        $result = DB::select(
            "SELECT m AS `month` FROM (
                SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') AS m FROM savings
                UNION SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') FROM angsuran
                UNION SELECT DATE_FORMAT(tanggal_pengajuan, '%Y-%m') FROM pinjaman
            ) t ORDER BY m"
        );

        return collect($result)
            ->map(fn ($row) => substr($row->month, 0, 4))
            ->unique()
            ->values()
            ->all();
    }
}