<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicRegisterRequest;
use App\Models\Member;
use App\Models\Pinjaman;
use App\Models\Saving;
use App\Models\ShuDistribution;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'totalAnggota' => Member::count(),
            'totalSimpanan' => (float) Saving::sum('jumlah'),
            'totalPinjaman' => Pinjaman::where('status', 'disetujui')->count(),
            'totalShu' => (float) ShuDistribution::sum('total_shu'),
        ]);
    }

    public function register()
    {
        return view('public_register');
    }

    // Ganti (Request $request) menjadi (PublicRegisterRequest $request)
    public function store(PublicRegisterRequest $request)
    {
        // Ambil data yang sudah lolos validasi
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('members-photos', 'public');
        }
        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')->store('members-docs', 'public');
        }
        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')->store('members-docs', 'public');
        }
        if ($request->hasFile('file_sertifikat_tanah')) {
            $data['file_sertifikat_tanah'] = $request->file('file_sertifikat_tanah')->store('members-docs', 'public');
        }

        // SET DATA DEFAULT
        $data['nomor_anggota'] = 'REG-'.rand(1000, 9999);
        $data['status'] = 'pending';
        $data['tanggal_bergabung'] = now();
        $data['status_cetak'] = false;

        Member::create($data);

        return redirect()->route('landing')->with('success', 'Pendaftaran Berhasil! Silakan tunggu verifikasi Admin.');
    }
}
