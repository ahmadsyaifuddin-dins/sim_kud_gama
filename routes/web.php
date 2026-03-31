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

Route::get('/', function () {
    return view('welcome');
});

// ROUTE PUBLIK (Tanpa Login)
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/daftar-anggota', [LandingController::class, 'register'])->name('public.register');
Route::post('/daftar-anggota', [LandingController::class, 'store'])->name('public.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('members', MemberController::class);
    Route::put('/members/{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::get('members/{member}/print-card', [MemberController::class, 'printCard'])->name('members.print_card');
    Route::get('members/{member}/print-receipt', [MemberController::class, 'printReceipt'])->name('members.print_receipt');

    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('angsuran', AngsuranController::class);

    // MODULE 3: IURAN / SIMPANAN
    Route::resource('savings', SavingController::class);

    // MODULE 5: PENGURUS
    Route::resource('managements', ManagementController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/cek-anggota/{id}', [ValidationController::class, 'check'])->name('members.check');
});

require __DIR__.'/auth.php';
