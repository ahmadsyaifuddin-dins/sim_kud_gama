<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAngsuranRequest;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use App\Services\LoanCalculator;
use App\Services\PeriodClosureService;
use Illuminate\Support\Facades\Auth;

class AngsuranController extends Controller
{
    public function index()
    {
        // Ambil data angsuran beserta relasi pinjaman (dan anggota) serta admin yang input
        $angsurans = Angsuran::with(['pinjaman.member', 'user'])->latest()->get();

        return view('angsuran.index', compact('angsurans'));
    }

    public function create()
    {
        // Hanya tampilkan pinjaman yang sudah disetujui untuk diangsur
        $pinjamans = Pinjaman::with('member')->where('status', 'disetujui')->get();

        [$loanScheduleMap, $dendaPerHari] = $this->buildLoanScheduleMap($pinjamans);

        return view('angsuran.create', compact('pinjamans', 'loanScheduleMap', 'dendaPerHari'));
    }

    public function store(StoreAngsuranRequest $request)
    {
        $validated = $request->validated();

        // Kunci periode: cegah input pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($validated['tanggal_bayar'])) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $validated['tanggal_bayar']);

            return back()->withErrors($errors);
        }

        $pinjaman = Pinjaman::findOrFail($validated['pinjaman_id']);

        // Tidak boleh mengangsur pinjaman yang belum disetujui
        if ($pinjaman->status !== 'disetujui') {
            return back()->withErrors(['pinjaman_id' => 'Pinjaman tidak dapat diangsur karena belum disetujui / sudah lunas.']);
        }

        // Cegah duplikasi angsuran ke-<n> pada pinjaman yang sama
        $duplicate = Angsuran::where('pinjaman_id', $pinjaman->id)
            ->where('angsuran_ke', $validated['angsuran_ke'])
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['angsuran_ke' => "Angsuran ke-{$validated['angsuran_ke']} untuk pinjaman ini sudah pernah dibayar."]);
        }

        if ((int) $validated['angsuran_ke'] > (int) $pinjaman->lama_angsuran) {
            return back()->withErrors(['angsuran_ke' => 'Nomor angsuran melebihi lama tenor pinjaman.']);
        }

        // Otomasi rincian angsuran bila pinjaman memakai skema bunga baru
        $dendaInfo = null;
        if (! is_null($pinjaman->jenis_bunga)) {
            $ke = (int) $validated['angsuran_ke'];
            $breakdown = LoanCalculator::breakdown($pinjaman, $ke);
            $due = LoanCalculator::dueDate($pinjaman, $ke);
            $denda = LoanCalculator::denda($pinjaman, $ke, $validated['tanggal_bayar']);

            $validated['jumlah_pokok'] = $breakdown['pokok'];
            $validated['jumlah_bunga'] = $breakdown['bunga'];
            $validated['jumlah_denda'] = $denda;
            $validated['tanggal_jatuh_tempo'] = $due->format('Y-m-d');
            $validated['jumlah_bayar'] = round($breakdown['pokok'] + $breakdown['bunga'] + $denda, 2);

            if ($denda > 0) {
                $dendaInfo = [
                    'hari' => $due->startOfDay()->diffInDays(\Carbon\Carbon::parse($validated['tanggal_bayar'])->startOfDay()),
                    'jumlah' => $denda,
                ];
            }
        }

        $validated['user_id'] = Auth::id();

        // Upload bukti bayar (Old School Way)
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/angsuran'), $filename);
            $validated['bukti_bayar'] = 'uploads/angsuran/'.$filename;
        }

        Angsuran::create($validated);

        // Otomasi: tandai lunas bila seluruh angsuran sudah terbayar
        $this->syncStatusLunas($pinjaman->id);

        $pesan = 'Data angsuran dan bukti bayar berhasil disimpan.';
        if ($dendaInfo) {
            $pesan = "Data angsuran disimpan. Telat {$dendaInfo['hari']} hari, denda Rp ".number_format($dendaInfo['jumlah'], 0, ',', '.').' telah dihitung otomatis.';
        }

        return redirect()->route('angsuran.index')->with('success', $pesan);
    }

    public function edit(Angsuran $angsuran)
    {
        // Untuk mode edit, tampilkan semua pinjaman
        $pinjamans = Pinjaman::with('member')->get();

        [$loanScheduleMap, $dendaPerHari] = $this->buildLoanScheduleMap($pinjamans);

        return view('angsuran.edit', compact('angsuran', 'pinjamans', 'loanScheduleMap', 'dendaPerHari'));
    }

    public function update(StoreAngsuranRequest $request, Angsuran $angsuran)
    {
        $validated = $request->validated();

        // Kunci periode: cegah perubahan pada periode yang sudah ditutup (cek tanggal baru & tanggal lama)
        if (PeriodClosureService::isLocked($validated['tanggal_bayar']) || PeriodClosureService::isLocked($angsuran->tanggal_bayar)) {
            $keduanya = collect([$validated['tanggal_bayar'], $angsuran->tanggal_bayar]);
            $tanggalTerkunci = $keduanya->first(fn ($t) => PeriodClosureService::isLocked($t));
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $tanggalTerkunci);

            return back()->withErrors($errors);
        }

        $pinjaman = $angsuran->pinjaman;

        // Hitung ulang otomatis bila memakai skema bunga baru
        if (! is_null($pinjaman->jenis_bunga)) {
            $ke = (int) $validated['angsuran_ke'];
            $breakdown = LoanCalculator::breakdown($pinjaman, $ke);
            $due = LoanCalculator::dueDate($pinjaman, $ke);
            $denda = LoanCalculator::denda($pinjaman, $ke, $validated['tanggal_bayar']);

            $validated['jumlah_pokok'] = $breakdown['pokok'];
            $validated['jumlah_bunga'] = $breakdown['bunga'];
            $validated['jumlah_denda'] = $denda;
            $validated['tanggal_jatuh_tempo'] = $due->format('Y-m-d');
            $validated['jumlah_bayar'] = round($breakdown['pokok'] + $breakdown['bunga'] + $denda, 2);
        }

        // Cek kalau ada upload bukti bayar baru
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/angsuran'), $filename);
            $validated['bukti_bayar'] = 'uploads/angsuran/'.$filename;
        }

        $angsuran->update($validated);

        return redirect()->route('angsuran.index')->with('success', 'Data pembayaran angsuran berhasil diperbarui!');
    }

    public function destroy(Angsuran $angsuran)
    {
        // Kunci periode: cegah penghapusan pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($angsuran->tanggal_bayar)) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $angsuran->tanggal_bayar);

            return back()->withErrors($errors);
        }

        $pinjamanId = $angsuran->pinjaman_id;

        // Hapus file bukti dari folder public (jika ada)
        if ($angsuran->bukti_bayar && file_exists(public_path($angsuran->bukti_bayar))) {
            unlink(public_path($angsuran->bukti_bayar));
        }

        $angsuran->delete();

        // Otomasi: jika sudah 'lunas' tapi ada angsuran yang dihapus, kembalikan ke 'disetujui'
        $this->syncStatusLunas($pinjamanId);

        return redirect()->route('angsuran.index')->with('success', 'Data angsuran berhasil dihapus!');
    }

    /**
     * Bangun peta skedul angsuran untuk pratinjau otomatis di form.
     */
    private function buildLoanScheduleMap($pinjamans): array
    {
        $map = [];
        $dendaPerHari = (float) \App\Support\Setting::get('denda_per_hari', 5000);

        foreach ($pinjamans as $pinjaman) {
            $map[$pinjaman->id] = [
                'nama' => optional($pinjaman->member)->nama_lengkap,
                'jenis_bunga' => $pinjaman->jenis_bunga,
                'persentase' => (float) $pinjaman->persentase_bunga,
                'tenor' => (int) $pinjaman->lama_angsuran,
                'dihitung' => ! is_null($pinjaman->jenis_bunga),
                'schedule' => ! is_null($pinjaman->jenis_bunga)
                    ? LoanCalculator::schedule($pinjaman)
                    : [],
            ];
        }

        return [$map, $dendaPerHari];
    }

    /**
     * Sinkronkan status pinjaman dengan kelengkapan angsuran.
     */
    private function syncStatusLunas(int $pinjamanId): void
    {
        $pinjaman = Pinjaman::find($pinjamanId);

        if (! $pinjaman) {
            return;
        }

        $coveredKe = Angsuran::where('pinjaman_id', $pinjamanId)
            ->pluck('angsuran_ke')
            ->map(fn ($v) => (int) $v)
            ->flip();

        $lengkap = true;

        for ($i = 1; $i <= (int) $pinjaman->lama_angsuran; $i++) {
            if (! $coveredKe->has($i)) {
                $lengkap = false;
                break;
            }
        }

        if ($lengkap && $pinjaman->status === 'disetujui') {
            $pinjaman->update(['status' => 'lunas']);
        } elseif (! $lengkap && $pinjaman->status === 'lunas') {
            $pinjaman->update(['status' => 'disetujui']);
        }
    }
}