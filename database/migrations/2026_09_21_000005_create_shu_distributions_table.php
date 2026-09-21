<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shu_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('period_key')->unique()->comment('Tahun periode SHU, misal: 2026');
            $table->string('label')->comment('Label periode, misal: Tahun Buku 2026');
            $table->decimal('total_shu', 15, 2)->comment('Total SHU yang dibagikan');
            $table->decimal('jasa_modal_persen', 5, 2)->comment('Persentase Jasa Usaha / Modal');
            $table->decimal('jasa_transaksi_persen', 5, 2)->comment('Persentase Jasa Transaksi / Pinjaman');
            $table->decimal('cadangan_persen', 5, 2)->comment('Persentase Cadangan');
            $table->decimal('total_jasa_modal', 15, 2)->default(0);
            $table->decimal('total_jasa_transaksi', 15, 2)->default(0);
            $table->decimal('total_cadangan', 15, 2)->default(0);
            $table->unsignedInteger('total_member')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('calculated_at')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shu_distributions');
    }
};