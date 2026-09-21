<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shu_member_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shu_distribution_id')->constrained('shu_distributions')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->decimal('saldo_simpanan', 15, 2)->default(0)->comment('Total simpanan s/d akhir periode');
            $table->decimal('jasa_modal', 15, 2)->default(0)->comment('Jasa Usaha / Modal anggota');
            $table->decimal('total_transaksi', 15, 2)->default(0)->comment('Aktivitas transaksi dalam periode');
            $table->decimal('jasa_transaksi', 15, 2)->default(0)->comment('Jasa Transaksi / Pinjaman anggota');
            $table->decimal('total_shu', 15, 2)->default(0)->comment('Total SHU yang diterima anggota');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shu_member_distributions');
    }
};