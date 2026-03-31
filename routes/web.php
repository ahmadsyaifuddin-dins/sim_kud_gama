<?php

use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

// ROUTE PUBLIK (Tanpa Login)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/daftar-anggota', [LandingController::class, 'register'])->name('public.register');
Route::post('/daftar-anggota', [LandingController::class, 'store'])->name('public.store');

// ROUTE DASHBOARD (Semua Role Bisa Akses)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ROUTE AUTHENTICATED
Route::middleware('auth')->group(function () {

    // Rute Profil & Umum (Bisa diakses Admin & Pimpinan)
    Route::view('about', 'about')->name('about');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Laporan (Pimpinan fokus ke sini, Admin juga bisa)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    // ==========================================================
    // RUTE KHUSUS ADMIN (DIKUNCI DENGAN MIDDLEWARE ROLE)
    // ==========================================================
    Route::middleware('role:admin')->group(function () {

        // Modul Manajemen User
        Route::resource('users', UserController::class);

        // Modul Anggota
        Route::resource('members', MemberController::class);
        Route::put('/members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
        Route::get('members/{member}/print-card', [MemberController::class, 'printCard'])->name('members.print_card');
        Route::get('members/{member}/print-receipt', [MemberController::class, 'printReceipt'])->name('members.print_receipt');
        Route::get('/cek-anggota/{id}', [ValidationController::class, 'check'])->name('members.check');

        // Modul Iuran & Simpanan
        Route::resource('savings', SavingController::class);

        // Modul Pinjaman & Angsuran
        Route::resource('pinjaman', PinjamanController::class);
        Route::resource('angsuran', AngsuranController::class);

        // Modul Pengurus
        Route::resource('managements', ManagementController::class);

    });
});

require __DIR__.'/auth.php';
