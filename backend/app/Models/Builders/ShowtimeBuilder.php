<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ShowtimeBuilder extends Builder
{
    public function withApiRelations(): self
    {
        return $this
            ->with(['movie', 'hall'])
            ->withCount('reservedSeats');
    }

    public function orderedByStart(): self
    {
        return $this->orderBy('starts_at');
    }
}
