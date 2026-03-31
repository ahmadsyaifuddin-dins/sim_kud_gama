<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        // Validasi sudah di-handle oleh StoreUserRequest
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'], // Menyimpan role ke DB
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Validasi sudah di-handle oleh UpdateUserRequest
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'], // Mengupdate role
        ];

        // Hanya update password jika input tidak kosong
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Mencegah user menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri saat sedang login.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
