<?php

namespace App\Http\Controllers;

use App\Console\Commands\SendPengingatTagihan;
use App\Http\Requests\StorePinjamanRequest;
use App\Http\Requests\UpdatePinjamanRequest;
use App\Http\Requests\UpdateStatusPinjamanRequest;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Services\LoanCalculator;
use App\Services\PeriodClosureService;
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

        // Kunci periode: cegah pengajuan pada periode yang sudah ditutup
        if (PeriodClosureService::isLocked($validated['tanggal_pengajuan'])) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_pengajuan', $validated['tanggal_pengajuan']);

            return back()->withErrors($errors);
        }

        $validated['user_id'] = Auth::id(); // Mencatat admin yang menginput

        Pinjaman::create($validated);

        return redirect()->route('pinjaman.index')->with('success', 'Pengajuan pinjaman berhasil disimpan.');
    }

    public function create()
    {
        // Ambil data anggota yang aktif saja untuk dipilih di dropdown
        $members = Member::with('savings')->where('status', 'active')->get();

        // Informasi plafond setiap anggota untuk pratinjau di form
        $membersPlafond = $members->mapWithKeys(function ($member) {
            return [
                $member->id => [
                    'plafond' => LoanCalculator::plafond($member),
                    'saldo_pokok_wajib' => LoanCalculator::saldoPokokWajib($member),
                    'luasan_lahan' => (float) ($member->luasan_lahan ?? 0),
                ],
            ];
        });

        return view('pinjaman.create', compact('members', 'membersPlafond'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $members = Member::with('savings')->where('status', 'active')->get();

        $membersPlafond = $members->mapWithKeys(function ($member) {
            return [
                $member->id => [
                    'plafond' => LoanCalculator::plafond($member),
                    'saldo_pokok_wajib' => LoanCalculator::saldoPokokWajib($member),
                    'luasan_lahan' => (float) ($member->luasan_lahan ?? 0),
                ],
            ];
        });

        return view('pinjaman.edit', compact('pinjaman', 'members', 'membersPlafond'));
    }

    public function update(UpdatePinjamanRequest $request, Pinjaman $pinjaman)
    {
        $validated = $request->validated();

        // Kunci periode: cegah perubahan jika tanggal baru / lama berada di periode tertutup
        if (PeriodClosureService::isLocked($validated['tanggal_pengajuan']) || PeriodClosureService::isLocked($pinjaman->tanggal_pengajuan)) {
            $tanggalTerkunci = PeriodClosureService::isLocked($validated['tanggal_pengajuan'])
                ? $validated['tanggal_pengajuan']
                : $pinjaman->tanggal_pengajuan;
            $errors = PeriodClosureService::lockErrorMessage('tanggal_pengajuan', $tanggalTerkunci);

            return back()->withErrors($errors);
        }

        $pinjaman->update($validated);

        return redirect()->route('pinjaman.index')->with('success', 'Data pengajuan pinjaman berhasil diperbarui!');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        // Kunci periode: cegah penghapusan data periode yang sudah ditutup
        if (PeriodClosureService::isLocked($pinjaman->tanggal_pengajuan)) {
            $errors = PeriodClosureService::lockErrorMessage('tanggal_pengajuan', $pinjaman->tanggal_pengajuan);

            return back()->withErrors($errors);
        }

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
        $cicilan_per_bulan = 'Rp '.number_format(LoanCalculator::angsuranPerBulan($pinjaman), 0, ',', '.');
        $tenor = $pinjaman->lama_angsuran;

        if ($pinjaman->status === 'disetujui') {
            return "Halo *{$nama}*,

            Kabar baik! Pengajuan pinjaman Anda di *KUD Gajah Mada* telah *DISETUJUI*.

            *Detail Pinjaman:*
            • Nominal Pinjaman: {$jumlah}
            • Tenor: {$tenor} Bulan
            • Bunga: *".($pinjaman->persentase_bunga ?? 0)."%/bulan* (".strtoupper($pinjaman->jenis_bunga ?? 'flat').")
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
