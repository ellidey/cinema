<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class SeatBuilder extends Builder
{
    public function withHall(): self
    {
        return $this->with('hall');
    }

    public function forHall(?int $hallId): self
    {
        return $this->when(
            $hallId,
            fn (self $query, int $id) => $query->where('hall_id', $id),
        );
    }

    public function orderedForHall(): self
    {
        return $this
            ->orderBy('hall_id')
            ->orderBy('row')
            ->orderBy('number');
    }
}
