<?php

namespace App\Http\Controllers;

use App\Models\PeriodClosure;
use App\Services\PeriodClosureService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PeriodController extends Controller
{
    /**
     * Halaman kelola tutup buku (opening/closure periode).
     */
    public function index()
    {
        $monthlyClosures = PeriodClosure::with('approver')->where('type', 'monthly')->latest()->get();
        $yearlyClosures = PeriodClosure::with('approver')->where('type', 'yearly')->latest()->get();

        $availableMonthly = PeriodClosureService::availableMonthly();
        $availableYearly = PeriodClosureService::availableYearly();

        return view('periods.index', compact(
            'monthlyClosures',
            'yearlyClosures',
            'availableMonthly',
            'availableYearly',
        ));
    }

    /**
     * Tutup / kunci sebuah periode (bulanan atau tahunan).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:monthly,yearly'],
            'period_key' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $periodKey = trim($validated['period_key']);
        $type = $validated['type'];

        // Validasi tambahan: format key harus sesuai tipe
        if ($type === 'monthly' && ! preg_match('/^\d{4}-\d{2}$/', $periodKey)) {
            return back()->withErrors(['period_key' => 'Format periode bulanan tidak valid (contoh: 2026-09).']);
        }

        if ($type === 'yearly' && ! preg_match('/^\d{4}$/', $periodKey)) {
            return back()->withErrors(['period_key' => 'Format periode tahunan tidak valid (contoh: 2026).']);
        }

        $duplicate = PeriodClosure::where('type', $type)->where('period_key', $periodKey)->exists();
        if ($duplicate) {
            return back()->withErrors(['period_key' => 'Periode tersebut sudah pernah ditutup.']);
        }

        $closure = PeriodClosureService::close($type, $periodKey, $validated['note'] ?? null);

        return redirect()->route('periods.index')->with(
            'success',
            "Periode {$closure->label} telah ditutup (dikunci). Transaksi di dalamnya menjadi read-only."
        );
    }

    /**
     * Buka kembali periode yang terkunci.
     */
    public function destroy(PeriodClosure $closure)
    {
        $closure->delete();

        return redirect()->route('periods.index')->with(
            'success',
            "Periode {$closure->label} telah dibuka kembali. Transaksi di dalamnya dapat diproses lagi."
        );
    }
}