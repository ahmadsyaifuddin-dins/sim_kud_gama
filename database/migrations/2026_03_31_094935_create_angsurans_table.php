<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angsuran', function (Blueprint $table) { // Nama tabel eksplisit
            $table->id();
            $table->foreignId('pinjaman_id')->constrained('pinjaman')->cascadeOnDelete();
            $table->integer('angsuran_ke');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->string('bukti_bayar')->nullable()->comment('Path folder public/uploads');
            $table->foreignId('user_id')->constrained('users')->comment('Admin yang menerima');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angsuran');
    }
};
