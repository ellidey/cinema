<?php

namespace App\Actions;

use App\Models\ReservedSeat;

class PayReservedSeatAction
{
    public function execute(ReservedSeat $reservedSeat): ReservedSeat
    {
        $reservedSeat->update([
            'status' => ReservedSeat::STATUS_PAID,
        ]);

        return $reservedSeat->refresh();
    }
}
