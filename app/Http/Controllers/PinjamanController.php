<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePinjamanRequest;
use App\Http\Requests\UpdatePinjamanRequest;
use App\Http\Requests\UpdateStatusPinjamanRequest;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function index()
    {
        // Mengambil semua data pinjaman beserta relasi anggota dan user/admin yang memproses
        // Diurutkan dari yang terbaru
        $pinjamans = Pinjaman::with(['member', 'user'])->latest()->get();

        return view('pinjaman.index', compact('pinjamans'));
    }

    public function store(StorePinjamanRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id(); // Mencatat admin yang menginput

        Pinjaman::create($validated);

        return redirect()->route('pinjaman.index')->with('success', 'Pengajuan pinjaman berhasil disimpan.');
    }

    public function create()
    {
        // Ambil data anggota yang aktif saja untuk dipilih di dropdown
        $members = Member::where('status', 'active')->get();

        return view('pinjaman.create', compact('members'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $members = Member::where('status', 'active')->get();

        return view('pinjaman.edit', compact('pinjaman', 'members'));
    }

    public function update(UpdatePinjamanRequest $request, Pinjaman $pinjaman)
    {
        $validated = $request->validated();
        $pinjaman->update($validated);

        return redirect()->route('pinjaman.index')->with('success', 'Data pengajuan pinjaman berhasil diperbarui!');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus!');
    }

    public function updateStatus(UpdateStatusPinjamanRequest $request, Pinjaman $pinjaman)
    {
        $validated = $request->validated();

        // Jika status diubah menjadi disetujui, catat tanggal pencairan hari ini
        if ($validated['status'] === 'disetujui') {
            $validated['tanggal_pencairan'] = Carbon::now()->format('Y-m-d');
        }

        $pinjaman->update($validated);

        // Ambil data anggota yang berelasi untuk mendapatkan nomor HP
        $member = $pinjaman->member;

        // Kirim notifikasi jika nomor HP tersedia
        if ($member && $member->no_hp) {
            $pesan = $this->generatePesanStatus($pinjaman, $member->nama_lengkap);
            WhatsAppService::send($member->no_hp, $pesan);
        }

        return redirect()->back()->with('success', 'Status pinjaman diperbarui dan notifikasi WhatsApp telah dikirim.');
    }

    private function generatePesanStatus(Pinjaman $pinjaman, string $nama): string
    {
        $jumlah = 'Rp '.number_format($pinjaman->jumlah_pinjaman, 0, ',', '.');

        if ($pinjaman->status === 'disetujui') {
            return "Halo {$nama},\n\nPengajuan pinjaman Anda sebesar {$jumlah} telah *DISETUJUI* oleh KUD Gajah Mada. Dana sudah dapat dicairkan. Terima kasih.";
        } elseif ($pinjaman->status === 'ditolak') {
            return "Halo {$nama},\n\nMohon maaf, pengajuan pinjaman Anda sebesar {$jumlah} *DITOLAK*. Silakan hubungi pengurus untuk informasi lebih lanjut.";
        }

        return "Halo {$nama},\n\nStatus pinjaman Anda saat ini adalah: ".strtoupper($pinjaman->status).'.';
    }
}
