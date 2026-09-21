<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Pinjaman;
use App\Support\Setting;
use Carbon\Carbon;

class LoanCalculator
{
    /**
     * Suku bunga bulanan (desimal). Contoh: 1,5% => 0.015
     */
    public static function monthlyRate(Pinjaman $pinjaman): float
    {
        $persen = $pinjaman->persentase_bunga !== null && $pinjaman->persentase_bunga !== ''
            ? (float) $pinjaman->persentase_bunga
            : (float) Setting::get('default_persentase_bunga', 1.5);

        return $persen / 100;
    }

    /**
     * Besar angsuran per bulan (pokok + bunga) sesuai metode bunga.
     * flat  : (P + P*i*n) / n
     * menurun (anuitas): P * i * (1+i)^n / ((1+i)^n - 1)
     */
    public static function angsuranPerBulan(Pinjaman $pinjaman): float
    {
        $P = (float) $pinjaman->jumlah_pinjaman ?: 1;
        $n = (int) $pinjaman->lama_angsuran;
        $i = self::monthlyRate($pinjaman);

        if ($n <= 0) {
            return 0;
        }

        if ($pinjaman->jenis_bunga === 'menurun') {
            $pow = pow(1 + $i, $n);
            return ($P * $i * $pow) / ($pow - 1);
        }

        // Flat
        return ($P + ($P * $i * $n)) / $n;
    }

    /**
     * Rincian pokok & bunga untuk angsuran ke-$ke.
     *
     * @param int $ke 1-indexed
     * @return array{pokok: float, bunga: float}
     */
    public static function breakdown(Pinjaman $pinjaman, int $ke): array
    {
        $P = (float) $pinjaman->jumlah_pinjaman;
        $n = (int) $pinjaman->lama_angsuran;
        $i = self::monthlyRate($pinjaman);
        $ke = max(1, min($ke, $n));

        if ($pinjaman->jenis_bunga === 'menurun') {
            $A = self::angsuranPerBulan($pinjaman);
            $sisa = $P;

            for ($k = 1; $k <= $n; $k++) {
                $bunga = $sisa * $i;
                $pokok = $A - $bunga;

                if ($k === $ke) {
                    // Pastikan angsuran terakhir menutup sisa pokok sepenuhnya (hindari sisa nol/negatif)
                    if ($ke === $n) {
                        $pokok = $sisa;
                    }

                    return ['pokok' => round($pokok, 2), 'bunga' => round($bunga, 2)];
                }

                $sisa = $sisa - $pokok;
                if ($sisa < 0) {
                    $sisa = 0;
                }
            }

            return ['pokok' => round($sisa, 2), 'bunga' => 0];
        }

        // Flat
        $pokokPerBulan = $n > 0 ? $P / $n : 0;
        $bungaPerBulan = $P * $i;

        return [
            'pokok' => round($pokokPerBulan, 2),
            'bunga' => round($bungaPerBulan, 2),
        ];
    }

    /**
     * Tanggal jatuh tempo angsuran ke-$ke (hari menyesuaikan tanggal pencairan/pengajuan).
     */
    public static function dueDate(Pinjaman $pinjaman, int $ke): Carbon
    {
        $base = $pinjaman->tanggal_pencairan
            ? Carbon::parse($pinjaman->tanggal_pencairan)
            : Carbon::parse($pinjaman->tanggal_pengajuan);

        $due = $base->copy()->addMonths($ke - 1);
        $day = $base->day;
        $lastDay = $due->copy()->endOfMonth()->day;

        $due->day = min($day, $lastDay);

        return $due;
    }

    /**
     * Denda keterlambatan (Rp) jika tanggal bayar melewati jatuh tempo.
     * Denda = jumlah hari telat x tarif denda per hari (pengaturan 'denda_per_hari').
     */
    public static function denda(Pinjaman $pinjaman, int $ke, $tanggalBayar): float
    {
        $due = self::dueDate($pinjaman, $ke);
        $bayar = Carbon::parse($tanggalBayar);

        $lateDays = $due->copy()->startOfDay()->diffInDays($bayar->copy()->startOfDay(), false);

        if ($lateDays <= 0) {
            return 0;
        }

        $tarif = (float) Setting::get('denda_per_hari', 5000);

        return round($lateDays * $tarif, 2);
    }

    /**
     * Skedul lengkap angsuran sebuah pinjaman (untuk pratinjau).
     *
     * @return array<int, array{ke:int, tanggal_jatuh_tempo:string, jumlah_pokok:float, jumlah_bunga:float}>
     */
    public static function schedule(Pinjaman $pinjaman): array
    {
        $n = (int) $pinjaman->lama_angsuran;
        $schedule = [];

        for ($ke = 1; $ke <= $n; $ke++) {
            $bd = self::breakdown($pinjaman, $ke);
            $schedule[] = [
                'ke' => $ke,
                'tanggal_jatuh_tempo' => self::dueDate($pinjaman, $ke)->format('Y-m-d'),
                'jumlah_pokok' => $bd['pokok'],
                'jumlah_bunga' => $bd['bunga'],
            ];
        }

        return $schedule;
    }

    /**
     * Batas maksimal plafond pinjaman anggota.
     * Diambil dari nilai TERBESAR antara:
     *  - (luasan lahan sawit x plafond_per_hektar)
     *  - (akumulasi saldo Simpanan Pokok + Wajib x plafond_multiplier_simpanan)
     */
    public static function plafond(Member $member): float
    {
        $perHektar = (float) Setting::get('plafond_per_hektar', 10000000);
        $multiplier = (float) Setting::get('plafond_multiplier_simpanan', 10);

        $limitLahan = (float) ($member->luasan_lahan ?? 0) * $perHektar;

        $saldoPokokWajib = (float) $member->savings()
            ->whereIn('jenis_simpanan', ['pokok', 'wajib'])
            ->sum('jumlah');

        $limitSimpanan = $saldoPokokWajib * $multiplier;

        return round(max($limitLahan, $limitSimpanan), 2);
    }

    /**
     * Akumulasi saldo Simpanan Pokok + Wajib anggota (untuk info di form).
     */
    public static function saldoPokokWajib(Member $member): float
    {
        return (float) $member->savings()
            ->whereIn('jenis_simpanan', ['pokok', 'wajib'])
            ->sum('jumlah');
    }
}