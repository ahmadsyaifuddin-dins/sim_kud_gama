<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('period_closures', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['monthly', 'yearly'])->comment('monthly = tutup buku bulanan, yearly = tutup buku tahunan');
            $table->string('label')->comment('Nama periode, misal: September 2026 atau 2026');
            $table->string('period_key')->unique()->comment('Kunci unik periode, misal: 2026-09 atau 2026');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('closed_at')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('period_closures');
    }
};