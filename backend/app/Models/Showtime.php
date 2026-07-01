<?php

namespace App\Models;

use App\Models\Builders\ShowtimeBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showtime extends Model
{
    protected $fillable = [
        'starts_at',
        'movie_id',
        'hall_id',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }

    public function newEloquentBuilder($query): ShowtimeBuilder
    {
        return new ShowtimeBuilder($query);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
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
