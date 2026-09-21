<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran'; // Wajib ditambahkan

    protected $fillable = [
        'pinjaman_id', 'angsuran_ke', 'jumlah_bayar',
        'jumlah_pokok', 'jumlah_bunga', 'jumlah_denda', 'tanggal_jatuh_tempo',
        'tanggal_bayar', 'bukti_bayar', 'user_id',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'jumlah_pokok' => 'decimal:2',
        'jumlah_bunga' => 'decimal:2',
        'jumlah_denda' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
