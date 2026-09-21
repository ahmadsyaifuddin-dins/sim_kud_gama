<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShuMemberDistribution extends Model
{
    protected $table = 'shu_member_distributions';

    protected $fillable = [
        'shu_distribution_id', 'member_id',
        'saldo_simpanan', 'jasa_modal',
        'total_transaksi', 'jasa_transaksi',
        'total_shu',
    ];

    protected $casts = [
        'saldo_simpanan' => 'decimal:2',
        'jasa_modal' => 'decimal:2',
        'total_transaksi' => 'decimal:2',
        'jasa_transaksi' => 'decimal:2',
        'total_shu' => 'decimal:2',
    ];

    public function distribution()
    {
        return $this->belongsTo(ShuDistribution::class, 'shu_distribution_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}