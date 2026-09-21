<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    // Daftar kolom yang boleh diisi oleh admin
    protected $fillable = [
        'nomor_anggota',
        'nik',
        'status',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_lengkap',
        'dusun',
        'desa',
        'no_hp',
        'pekerjaan',
        'luasan_lahan',

        'file_sertifikat_tanah',
        'file_ktp',
        'file_kk',

        'biaya_pendaftaran',
        'file_bukti_bayar',
        'tanggal_bayar',

        'tanggal_bergabung',
        'foto',
        'status_cetak',
        'tanggal_cetak',
    ];

    // Mengubah format data secara otomatis agar mudah diolah codingan
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'status_cetak' => 'boolean', // 0 jadi false, 1 jadi true
        'tanggal_cetak' => 'datetime',
        'tanggal_bayar' => 'date',
    ];

    // Relasi: Satu anggota punya banyak data simpanan
    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    // Relasi: Satu anggota punya banyak pengajuan pinjaman
    public function pinjamen()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function shuDistributions()
    {
        return $this->hasMany(ShuMemberDistribution::class);
    }
}
