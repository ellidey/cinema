<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowtimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'starts_at' => $this->starts_at?->toISOString(),
            'movie_id' => $this->movie_id,
            'hall_id' => $this->hall_id,
            'movie' => new MovieResource($this->whenLoaded('movie')),
            'hall' => new HallResource($this->whenLoaded('hall')),
            'reserved_seats_count' => $this->whenCounted('reservedSeats'),
        ];
    }
}
