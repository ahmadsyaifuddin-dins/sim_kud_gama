<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman'; // Wajib ditambahkan

    protected $fillable = [
        'member_id', 'tanggal_pengajuan', 'jumlah_pinjaman', 'lama_angsuran',
        'keperluan', 'status', 'tanggal_pencairan', 'user_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'pinjaman_id');
    }
}
