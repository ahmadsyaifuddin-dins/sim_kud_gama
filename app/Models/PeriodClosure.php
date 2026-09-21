<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodClosure extends Model
{
    protected $table = 'period_closures';

    protected $fillable = [
        'type', 'label', 'period_key', 'start_date', 'end_date',
        'closed_by', 'closed_at', 'note',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'closed_at' => 'datetime',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function scopeLocking($query, $date)
    {
        return $query->where('start_date', '<=', $date)->where('end_date', '>=', $date);
    }
}