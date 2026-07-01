<?php

namespace App\Models;

use App\Models\Builders\SeatBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    protected $fillable = [
        'name',
        'row',
        'number',
        'price',
        'hall_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function newEloquentBuilder($query): SeatBuilder
    {
        return new SeatBuilder($query);
    }

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class);
    }

    public function reservedSeats(): HasMany
    {
        return $this->hasMany(ReservedSeat::class);
    }
}
