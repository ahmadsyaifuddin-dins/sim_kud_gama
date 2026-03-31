<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAngsuranRequest;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Auth;

class AngsuranController extends Controller
{
    public function store(StoreAngsuranRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        // Aturan #2: Upload file "Old School" langsung ke public/uploads/angsuran
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time().'_'.$file->getClientOriginalName();

            // Pindahkan file ke public/uploads/angsuran
            $file->move(public_path('uploads/angsuran'), $filename);

            // Simpan path ke database
            $validated['bukti_bayar'] = 'uploads/angsuran/'.$filename;
        }

        Angsuran::create($validated);

        return redirect()->route('angsuran.index')->with('success', 'Data angsuran dan bukti bayar berhasil disimpan.');
    }

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

        return view('angsuran.create', compact('pinjamans'));
    }

    public function edit(Angsuran $angsuran)
    {
        // Untuk mode edit, tampilkan semua pinjaman
        $pinjamans = Pinjaman::with('member')->get();

        return view('angsuran.edit', compact('angsuran', 'pinjamans'));
    }

    public function update(StoreAngsuranRequest $request, Angsuran $angsuran)
    {
        $validated = $request->validated();

        // Cek kalau ada upload bukti bayar baru ("Old School" way)
        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/angsuran'), $filename);

            // Timpa path lama dengan yang baru
            $validated['bukti_bayar'] = 'uploads/angsuran/'.$filename;
        }

        $angsuran->update($validated);

        return redirect()->route('angsuran.index')->with('success', 'Data pembayaran angsuran berhasil diperbarui!');
    }

    public function destroy(Angsuran $angsuran)
    {
        $angsuran->delete();

        return redirect()->route('angsuran.index')->with('success', 'Data angsuran berhasil dihapus!');
    }
}
