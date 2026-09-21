<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('angsuran', function (Blueprint $table) {
            // Rincian pembayaran: pokok, bunga, denda (nullable agar data lama tetap aman)
            $table->decimal('jumlah_pokok', 15, 2)->nullable()->after('jumlah_bayar');
            $table->decimal('jumlah_bunga', 15, 2)->nullable()->after('jumlah_pokok');
            $table->decimal('jumlah_denda', 15, 2)->nullable()->default(0)->after('jumlah_bunga');
            $table->date('tanggal_jatuh_tempo')->nullable()->after('tanggal_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('angsuran', function (Blueprint $table) {
            $table->dropColumn(['jumlah_pokok', 'jumlah_bunga', 'jumlah_denda', 'tanggal_jatuh_tempo']);
        });
    }
};