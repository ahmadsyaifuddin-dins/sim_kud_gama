<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavingRequest;
use App\Models\Member;
use App\Models\Saving;
use App\Services\PeriodClosureService;

class SavingController extends Controller
{
    public function index()
    {
        // Ambil data simpanan, urutkan dari yang terbaru
        // with('member') biar gak berat query-nya (Eager Loading)
        $savings = Saving::with('member')->latest()->paginate(10);

        return view('savings.index', compact('savings'));
    }

    public function create()
    {
        // Kita butuh daftar anggota buat dipilih di dropdown
        // Hanya ambil anggota yang AKTIF saja
        $members = Member::where('status', 'active')->orderBy('nama_lengkap')->get();

        return view('savings.create', compact('members'));
    }

    public function store(SavingRequest $request)
    {
        $data = $request->validated();

        // Kunci periode: cegah input transaksi pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($data['tanggal_bayar'])) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $data['tanggal_bayar']);

            return back()->withErrors($errors);
        }

        // 1. Upload Bukti Transfer (Old School Way)
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = time().'_'.$file->getClientOriginalName();

            // Pindahkan langsung ke public/uploads/savings
            $file->move(public_path('uploads/savings'), $filename);

            // Simpan path-nya saja ke DB
            $data['bukti_transfer'] = 'uploads/savings/'.$filename;
        }

        // 2. Catat User yang menginput (Admin yang login)
        $data['user_id'] = auth()->id();

        Saving::create($data);

        return redirect()->route('savings.index')->with('success', 'Transaksi simpanan berhasil dicatat!');
    }

    public function edit(Saving $saving)
    {
        $members = Member::where('status', 'active')->orderBy('nama_lengkap')->get();

        return view('savings.edit', compact('saving', 'members'));
    }

    public function update(SavingRequest $request, Saving $saving)
    {
        $data = $request->validated();

        // Kunci periode: cegah perubahan transaksi pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($data['tanggal_bayar'])) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $data['tanggal_bayar']);

            return back()->withErrors($errors);
        }

        if ($request->hasFile('bukti_transfer')) {
            // Hapus file lama jika ada (Old School Way)
            if ($saving->bukti_transfer && file_exists(public_path($saving->bukti_transfer))) {
                unlink(public_path($saving->bukti_transfer));
            }

            // Upload file baru
            $file = $request->file('bukti_transfer');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/savings'), $filename);

            $data['bukti_transfer'] = 'uploads/savings/'.$filename;
        }

        $saving->update($data);

        return redirect()->route('savings.index')->with('success', 'Data simpanan berhasil diperbarui.');
    }

    public function destroy(Saving $saving)
    {
        // Kunci periode: cegah penghapusan transaksi pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($saving->tanggal_bayar)) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_bayar', $saving->tanggal_bayar);

            return back()->withErrors($errors);
        }

        // Hapus file dari folder public sebelum data dihapus dari DB
        if ($saving->bukti_transfer && file_exists(public_path($saving->bukti_transfer))) {
            unlink(public_path($saving->bukti_transfer));
        }

        $saving->delete();

        return redirect()->route('savings.index')->with('success', 'Data transaksi dihapus.');
    }
}
