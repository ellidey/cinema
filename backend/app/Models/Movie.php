<?php

namespace App\Models;

use App\Models\Builders\MovieBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'duration',
    ];

    public function newEloquentBuilder($query): MovieBuilder
    {
        return new MovieBuilder($query);
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}
