<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'row' => $this->row,
            'number' => $this->number,
            'price' => $this->price,
            'hall_id' => $this->hall_id,
            'hall' => new HallResource($this->whenLoaded('hall')),
        ];
    }
}
