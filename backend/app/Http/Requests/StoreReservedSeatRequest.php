<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservedSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seat_id' => ['required', 'integer', 'exists:seats,id'],
            'showtime_id' => ['required', 'integer', 'exists:showtimes,id'],
        ];
    }
}
