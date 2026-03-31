<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran'; // Wajib ditambahkan

    protected $fillable = [
        'pinjaman_id', 'angsuran_ke', 'jumlah_bayar', 'tanggal_bayar',
        'bukti_bayar', 'user_id',
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
