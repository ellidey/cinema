<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ReservedSeatBuilder extends Builder
{
    public function withApiRelations(): self
    {
        return $this->with(['seat.hall', 'showtime.movie', 'showtime.hall']);
    }

    public function forShowtime(?int $showtimeId): self
    {
        return $this->when(
            $showtimeId,
            fn (self $query, int $id) => $query->where('showtime_id', $id),
        );
    }

    public function withStatus(?string $status): self
    {
        return $this->when(
            $status,
            fn (self $query, string $value) => $query->where('status', $value),
        );
    }

    public function latestReserved(): self
    {
        return $this->orderByDesc('reserved_at');
    }

    public function forSeatAndShowtime(int $seatId, int $showtimeId): self
    {
        return $this
            ->where('seat_id', $seatId)
            ->where('showtime_id', $showtimeId);
    }
}
