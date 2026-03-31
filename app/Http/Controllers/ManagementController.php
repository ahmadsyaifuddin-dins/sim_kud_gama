<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagementRequest;
use App\Models\Management;

class ManagementController extends Controller
{
    public function index()
    {
        // Urutkan: Yang masih aktif duluan, lalu berdasarkan tahun terbaru
        $managements = Management::orderBy('is_active', 'desc')
            ->orderBy('periode_mulai', 'desc')
            ->paginate(10);

        return view('managements.index', compact('managements'));
    }

    public function create()
    {
        return view('managements.create');
    }

    public function store(ManagementRequest $request)
    {
        $data = $request->validated();

        // UPLOAD OLD SCHOOL
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();

            // Pindah langsung ke public/uploads/managements
            $file->move(public_path('uploads/managements'), $filename);

            // Simpan path-nya saja ke DB
            $data['foto'] = 'uploads/managements/'.$filename;
        }

        // Set default is_active ke true (1) kalau tidak dikirim form
        if (! isset($data['is_active'])) {
            $data['is_active'] = 1;
        }

        Management::create($data);

        return redirect()->route('managements.index')->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(Management $management)
    {
        return view('managements.edit', compact('management'));
    }

    public function update(ManagementRequest $request, Management $management)
    {
        $data = $request->validated();

        // UPLOAD OLD SCHOOL (Dengan hapus foto lama)
        if ($request->hasFile('foto')) {
            // Cek dan hapus foto lama jika ada
            if ($management->foto && file_exists(public_path($management->foto))) {
                unlink(public_path($management->foto));
            }

            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();

            // Pindah langsung ke public/uploads/managements
            $file->move(public_path('uploads/managements'), $filename);

            // Timpa path-nya di array data
            $data['foto'] = 'uploads/managements/'.$filename;
        }

        // Checkbox handling: jika tidak dicentang, nilainya 0
        $data['is_active'] = $request->has('is_active');

        $management->update($data);

        return redirect()->route('managements.index')->with('success', 'Data pengurus diperbarui.');
    }

    public function destroy(Management $management)
    {
        // HAPUS FOTO OLD SCHOOL SEBELUM HAPUS DATA
        if ($management->foto && file_exists(public_path($management->foto))) {
            unlink(public_path($management->foto));
        }

        $management->delete();

        return redirect()->route('managements.index')->with('success', 'Data pengurus dihapus.');
    }
}
