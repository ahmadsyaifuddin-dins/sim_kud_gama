<?php

namespace App\Services;

use App\Models\PeriodClosure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

class PeriodClosureService
{
    /**
     * Cek apakah sebuah tanggal sudah masuk periode yang ditutup (dikunci).
     */
    public static function isLocked($date): bool
    {
        if (! $date) {
            return false;
        }

        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        return self::closureFor($date) !== null;
    }

    /**
     * Ambil objek penutupan periode untuk tanggal tertentu (null jika masih terbuka).
     */
    public static function closureFor($date): ?PeriodClosure
    {
        if (! $date) {
            return null;
        }

        $date = $date instanceof Carbon ? $date : Carbon::parse($date)->format('Y-m-d');

        return PeriodClosure::where('start_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->first();
    }

    /**
     * Pesan error seragam untuk transaksi pada periode terkunci.
     */
    public static function lockErrorMessage(string $field, $date): array
    {
        $closure = self::closureFor($date);
        $label = $closure ? $closure->label : 'periode terkait';

        return [$field => "Transaksi tidak dapat diproses karena periode {$label} sudah ditutup (dikunci read-only) untuk menjaga keamanan data kas yang telah diaudit. Silakan buka kembali periode tersebut terlebih dahulu."];
    }

    /**
     * Daftar periode yang tersedia (berisi transaksi tapi belum ditutup) untuk form tutup buku.
     *
     * @return array<int, array{key:string,label:string}>
     */
    public static function availableMonthly(): array
    {
        $months = self::transactionMonths();
        $closedKeys = PeriodClosure::where('type', 'monthly')->pluck('period_key')->flip();

        return $months->reject(fn ($item) => $closedKeys->has($item['key']))->values()->all();
    }

    /**
     * Daftar tahun yang tersedia untuk tutup buku tahunan.
     *
     * @return array<int, array{key:string,label:string}>
     */
    public static function availableYearly(): array
    {
        $years = self::transactionYears();
        $closedKeys = PeriodClosure::where('type', 'yearly')->pluck('period_key')->flip();

        return $years->reject(fn ($item) => $closedKeys->has($item['key']))->values()->all();
    }

    /**
     * Ambil daftar bulan (Y-m) yang memuat transaksi, terbaru dulu.
     */
    private static function transactionMonths(): \Illuminate\Support\Collection
    {
        $result = self::availableRaw();

        $items = collect($result)->map(fn ($row) => [
            'key' => $row->month,
            'label' => Carbon::createFromFormat('Y-m', $row->month)->translatedFormat('F Y'),
        ])->unique('key')->sortByDesc('key')->values();

        return $items;
    }

    /**
     * Ambil daftar tahun yang memuat transaksi, terbaru dulu.
     */
    private static function transactionYears(): \Illuminate\Support\Collection
    {
        $result = self::availableRaw();

        $items = collect($result)->map(fn ($row) => [
            'key' => substr($row->month, 0, 4),
            'label' => substr($row->month, 0, 4),
        ])->unique('key')->sortByDesc('key')->values();

        return $items;
    }

    /**
     * Query gabungan bulan-bulan yang memiliki aktivitas transaksi kas.
     */
    private static function availableRaw(): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT m AS `month` FROM (
                SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') AS m FROM savings
                UNION SELECT DATE_FORMAT(tanggal_bayar, '%Y-%m') FROM angsuran
                UNION SELECT DATE_FORMAT(tanggal_pengajuan, '%Y-%m') FROM pinjaman
            ) t ORDER BY m DESC"
        );
    }

    /**
     * Tutup (kunci) sebuah periode. Mengembalikan Label periode yang dibuat.
     */
    public static function close(string $type, string $periodKey, ?string $note = null): PeriodClosure
    {
        $isMonthly = $type === 'monthly';
        [$startDate, $endDate, $label] = $isMonthly
            ? self::monthlyRange($periodKey)
            : self::yearlyRange($periodKey);

        return PeriodClosure::create([
            'type' => $type,
            'label' => $label,
            'period_key' => $periodKey,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'closed_by' => Auth::id(),
            'closed_at' => now(),
            'note' => $note,
        ]);
    }

    /**
     * Hitung rentang tanggal satu bulan berdasarkan key Y-m.
     */
    private static function monthlyRange(string $periodKey): array
    {
        $start = Carbon::createFromFormat('Y-m', $periodKey)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        return [$start->format('Y-m-d'), $end->format('Y-m-d'), $start->translatedFormat('F Y')];
    }

    /**
     * Hitung rentang tanggal satu tahun berdasarkan key Y.
     */
    private static function yearlyRange(string $periodKey): array
    {
        $start = Carbon::createFromDate((int) $periodKey, 1, 1)->startOfYear();
        $end = $start->copy()->endOfYear();

        return [$start->format('Y-m-d'), $end->format('Y-m-d'), $periodKey];
    }
}