<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            // jenis bunga: flat (bunga tetap) atau menurun (anuitas)
            $table->enum('jenis_bunga', ['flat', 'menurun'])
                ->nullable()
                ->after('lama_angsuran')
                ->comment('flat = bunga tetap, menurun = bunga menurun/anuitas');

            // Persen bunga per bulan (misal 1.50 = 1,5% per bulan)
            $table->decimal('persentase_bunga', 5, 2)
                ->nullable()
                ->after('jenis_bunga')
                ->comment('Persentase jasa/bunga per bulan');
        });
    }

    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['jenis_bunga', 'persentase_bunga']);
        });
    }
};