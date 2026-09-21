<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShuDistribution extends Model
{
    protected $table = 'shu_distributions';

    protected $fillable = [
        'period_key', 'label', 'total_shu',
        'jasa_modal_persen', 'jasa_transaksi_persen', 'cadangan_persen',
        'total_jasa_modal', 'total_jasa_transaksi', 'total_cadangan',
        'total_member', 'created_by', 'calculated_at', 'note',
    ];

    protected $casts = [
        'total_shu' => 'decimal:2',
        'jasa_modal_persen' => 'decimal:2',
        'jasa_transaksi_persen' => 'decimal:2',
        'cadangan_persen' => 'decimal:2',
        'total_jasa_modal' => 'decimal:2',
        'total_jasa_transaksi' => 'decimal:2',
        'total_cadangan' => 'decimal:2',
        'calculated_at' => 'datetime',
    ];

    public function memberDistributions()
    {
        return $this->hasMany(ShuMemberDistribution::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}