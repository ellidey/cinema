<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'seats_count' => $this->whenCounted('seats'),
            'showtimes_count' => $this->whenCounted('showtimes'),
            'seats' => SeatResource::collection($this->whenLoaded('seats')),
        ];
    }
}
