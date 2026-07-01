<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservedSeat extends Model
{
    public const STATUS_UNPAID = 'unpaid';
    public const STATUS_PAID = 'paid';

    protected $fillable = [
        'reserved_at',
        'seat_id',
        'showtime_id',
        'price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'reserved_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }
}
