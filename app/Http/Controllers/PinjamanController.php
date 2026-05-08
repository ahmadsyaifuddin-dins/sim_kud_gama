<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendPengingatTagihan;
use App\Http\Requests\StorePinjamanRequest;
use App\Http\Requests\UpdatePinjamanRequest;
use App\Http\Requests\UpdateStatusPinjamanRequest;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
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
        // Kalkulasi format uang
        $jumlah = 'Rp '.number_format($pinjaman->jumlah_pinjaman, 0, ',', '.');
        $cicilan_per_bulan = 'Rp '.number_format($pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran, 0, ',', '.');
        $tenor = $pinjaman->lama_angsuran;

        if ($pinjaman->status === 'disetujui') {
            return "Halo *{$nama}*,

            Kabar baik! Pengajuan pinjaman Anda di *KUD Gajah Mada* telah *DISETUJUI*.

            *Detail Pinjaman:*
            • Nominal Pinjaman: {$jumlah}
            • Tenor: {$tenor} Bulan
            • Angsuran per Bulan: {$cicilan_per_bulan}
            
            Dana sudah dapat dicairkan. Silakan datang ke kantor KUD Gajah Mada dengan membawa Kartu Identitas (KTP/Kartu Anggota) pada jam kerja.
            
            Terima kasih atas kepercayaan Anda.";

        } elseif ($pinjaman->status === 'ditolak') {
            return "Halo *{$nama}*,
            
            Mohon maaf, pengajuan pinjaman Anda sebesar {$jumlah} saat ini *DITOLAK* setelah melalui proses verifikasi oleh pengurus KUD Gajah Mada.
            
            Silakan datang ke kantor atau hubungi pengurus untuk informasi lebih lanjut mengenai hal ini. 
            
            Terima kasih.";
        }

        return "Halo *{$nama}*,

        Status pengajuan pinjaman Anda (Nominal: {$jumlah}) saat ini adalah: *".strtoupper($pinjaman->status).'*.

        Terima kasih.';
    }

    // Method untuk mengirim WA massal sesuai Cron Job
    public function sendGlobalReminder()
    {
        // Alih-alih menggunakan Artisan::call(), kita langsung ambil angka hasilnya dari method statis
        $jumlahTerkirim = SendPengingatTagihan::prosesPengingatOtomatis();

        if ($jumlahTerkirim > 0) {
            return back()->with('success', "Pengecekan massal selesai. Berhasil mengirim {$jumlahTerkirim} pesan pengingat tagihan ke anggota.");
        } else {
            // Memberikan informasi jelas jika tidak ada yang jatuh tempo
            return back()->with('success', 'Pengecekan massal selesai. Saat ini tidak ada anggota yang jatuh tempo besok (0 pesan terkirim).');
        }
    }

    public function sendManualReminder(Pinjaman $pinjaman)
    {
        $member = $pinjaman->member;

        if ($member && $member->no_hp) {
            $cicilan = $pinjaman->jumlah_pinjaman / $pinjaman->lama_angsuran;
            $jumlahFormat = 'Rp '.number_format($cicilan, 0, ',', '.');

            // Pesan manual yang sedikit dimodifikasi agar universal (bisa untuk yang belum bayar/menunggak)
            $pesan = "Halo *{$member->nama_lengkap}*,

            Informasi penagihan dari *KUD Gajah Mada*.

            Kami mengingatkan tagihan angsuran pinjaman Anda sebesar *{$jumlahFormat}*. 

            Mohon untuk segera melakukan pembayaran di loket kantor KUD Gajah Mada. Jika Anda mengalami kendala, silakan hubungi pengurus KUD untuk berdiskusi.

            _(Abaikan pesan otomatis ini jika Anda sudah melakukan pembayaran hari ini)_.

            Terima kasih atas kerja samanya.";

            \App\Services\WhatsAppService::send($member->no_hp, $pesan);

            return back()->with('success', 'Pesan pengingat berhasil dikirim ke WhatsApp '.$member->nama_lengkap);
        }

        // Jika terjadi error (misal nomor HP kosong)
        return back()->withErrors(['error' => 'Gagal mengirim pesan. Nomor HP anggota tidak ditemukan.']);
    }
}
