<?php

namespace App\Models;

use App\Models\Builders\HallBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    protected $fillable = [
        'name',
    ];

    public function newEloquentBuilder($query): HallBuilder
    {
        return new HallBuilder($query);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}
