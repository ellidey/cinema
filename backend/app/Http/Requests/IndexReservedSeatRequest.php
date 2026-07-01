<?php

namespace App\Http\Requests;

use App\Models\ReservedSeat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexReservedSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'showtime_id' => ['sometimes', 'integer', 'exists:showtimes,id'],
            'status' => ['sometimes', Rule::in([ReservedSeat::STATUS_UNPAID, ReservedSeat::STATUS_PAID])],
        ];
    }
}
