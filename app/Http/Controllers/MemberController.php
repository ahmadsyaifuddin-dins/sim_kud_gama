<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    public function index()
    {
        // Urutkan: Pending duluan, baru tanggal terbaru
        $members = Member::orderByRaw("status = 'pending' DESC")
            ->latest()
            ->paginate(10);

        return view('members.index', compact('members'));
    }

    public function approve(Member $member)
    {
        // Ubah nomor anggota dari REG-XXX jadi KUD-GM-XXX
        $newNumber = 'KUD-GM-'.str_pad($member->id, 4, '0', STR_PAD_LEFT);

        $member->update([
            'status' => 'active',
            'nomor_anggota' => $newNumber,
        ]);

        return back()->with('success', 'Anggota berhasil diverifikasi & diaktifkan!');
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(MemberRequest $request)
    {
        $data = $request->validated();

        // 1. Upload Foto Profil (Old School)
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_foto_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/members/photos'), $filename);
            $data['foto'] = 'uploads/members/photos/'.$filename;
        }

        // 2. Upload Dokumen Persyaratan (Old School)
        $docs = ['file_sertifikat_tanah', 'file_ktp', 'file_kk'];
        foreach ($docs as $doc) {
            if ($request->hasFile($doc)) {
                $file = $request->file($doc);
                $filename = time().'_'.$doc.'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/members/docs'), $filename);
                $data[$doc] = 'uploads/members/docs/'.$filename;
            }
        }

        // 3. Upload Bukti Bayar (Old School)
        if ($request->hasFile('file_bukti_bayar')) {
            $file = $request->file('file_bukti_bayar');
            $filename = time().'_payment_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/members/payments'), $filename);
            $data['file_bukti_bayar'] = 'uploads/members/payments/'.$filename;

            // Otomatis set tanggal bayar hari ini jika user tidak isi manual
            if (empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = now();
            }
        }

        Member::create($data);

        return redirect()->route('members.index')->with('success', 'Anggota dan berkas berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(MemberRequest $request, Member $member)
    {
        $data = $request->validated();

        // 1. Update Foto Profil
        if ($request->hasFile('foto')) {
            if ($member->foto && file_exists(public_path($member->foto))) {
                unlink(public_path($member->foto));
            }
            $file = $request->file('foto');
            $filename = time().'_foto_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/members/photos'), $filename);
            $data['foto'] = 'uploads/members/photos/'.$filename;
        }

        // 2. Update Dokumen Persyaratan
        $docs = ['file_sertifikat_tanah', 'file_ktp', 'file_kk'];
        foreach ($docs as $doc) {
            if ($request->hasFile($doc)) {
                if ($member->$doc && file_exists(public_path($member->$doc))) {
                    unlink(public_path($member->$doc));
                }
                $file = $request->file($doc);
                $filename = time().'_'.$doc.'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/members/docs'), $filename);
                $data[$doc] = 'uploads/members/docs/'.$filename;
            }
        }

        // 3. Update Bukti Bayar
        if ($request->hasFile('file_bukti_bayar')) {
            if ($member->file_bukti_bayar && file_exists(public_path($member->file_bukti_bayar))) {
                unlink(public_path($member->file_bukti_bayar));
            }
            $file = $request->file('file_bukti_bayar');
            $filename = time().'_payment_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/members/payments'), $filename);
            $data['file_bukti_bayar'] = 'uploads/members/payments/'.$filename;

            // Set tanggal bayar otomatis saat update bukti jika kosong
            if (empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = now();
            }
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        // Hapus semua file secara Old School (unlink) sebelum hapus data dari DB
        $files = [
            $member->foto,
            $member->file_sertifikat_tanah,
            $member->file_ktp,
            $member->file_kk,
            $member->file_bukti_bayar,
        ];

        foreach ($files as $path) {
            if ($path && file_exists(public_path($path))) {
                unlink(public_path($path));
            }
        }

        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota beserta seluruh berkas berhasil dihapus.');
    }

    public function printCard(Member $member)
    {
        $member->update([
            'status_cetak' => true,
            'tanggal_cetak' => now(),
        ]);

        $validationUrl = route('members.check', $member->id);

        $qrCode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($validationUrl));

        $pdf = Pdf::loadView('members.card_pdf', compact('member', 'qrCode'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('KTA-'.$member->nomor_anggota.'.pdf');
    }

    public function printReceipt(Member $member)
    {
        if (! $member->file_bukti_bayar) {
            return back()->with('error', 'Anggota ini belum melakukan pembayaran!');
        }

        $pdf = Pdf::loadView('members.receipt_pdf', compact('member'));
        $pdf->setPaper('A5', 'landscape');

        return $pdf->stream('Kwitansi-'.$member->nomor_anggota.'.pdf');
    }
}
