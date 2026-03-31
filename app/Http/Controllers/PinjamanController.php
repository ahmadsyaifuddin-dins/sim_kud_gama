<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePinjamanRequest;
use App\Http\Requests\UpdatePinjamanRequest;
use App\Models\Member;
use App\Models\Pinjaman;
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
}
