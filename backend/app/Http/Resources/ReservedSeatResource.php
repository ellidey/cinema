<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservedSeatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reserved_at' => $this->reserved_at?->toISOString(),
            'seat_id' => $this->seat_id,
            'showtime_id' => $this->showtime_id,
            'price' => $this->price,
            'status' => $this->status,
            'seat' => new SeatResource($this->whenLoaded('seat')),
            'showtime' => new ShowtimeResource($this->whenLoaded('showtime')),
        ];
    }
}
