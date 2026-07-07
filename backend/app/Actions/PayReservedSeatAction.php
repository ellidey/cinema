<?php

namespace App\Actions;

use App\Models\ReservedSeat;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class PayReservedSeatAction
{
    public function execute(ReservedSeat $reservedSeat): ReservedSeat
    {
        return DB::transaction(function () use ($reservedSeat): ReservedSeat {
            $lockedReservedSeat = ReservedSeat::query()
                ->lockForUpdate()
                ->findOrFail($reservedSeat->id);

            if ($lockedReservedSeat->status === ReservedSeat::STATUS_PAID) {
                throw new ConflictHttpException('Reservation is already paid.');
            }

            $lockedReservedSeat->update([
                'status' => ReservedSeat::STATUS_PAID,
            ]);

            return $lockedReservedSeat->refresh();
        });
    }
}
