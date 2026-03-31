<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) { // Nama tabel eksplisit
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->integer('lama_angsuran')->comment('Dalam hitungan bulan');
            $table->text('keperluan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'lunas'])->default('menunggu');
            $table->date('tanggal_pencairan')->nullable();
            $table->foreignId('user_id')->constrained('users')->comment('Admin yang memproses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
