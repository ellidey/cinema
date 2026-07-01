<?php

namespace App\Actions;

use App\Models\ReservedSeat;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CreateReservedSeatAction
{
    public function execute(int $seatId, int $showtimeId): ReservedSeat
    {
        return DB::transaction(function () use ($seatId, $showtimeId): ReservedSeat {
            $seat = Seat::query()->lockForUpdate()->findOrFail($seatId);
            $showtime = Showtime::query()->findOrFail($showtimeId);

            if ($seat->hall_id !== $showtime->hall_id) {
                throw new UnprocessableEntityHttpException('Seat does not belong to the showtime hall.');
            }

            $isAlreadyReserved = ReservedSeat::query()
                ->forSeatAndShowtime($seat->id, $showtime->id)
                ->exists();

            if ($isAlreadyReserved) {
                throw new ConflictHttpException('Seat is already reserved for this showtime.');
            }

            return ReservedSeat::query()->create([
                'reserved_at' => now(),
                'seat_id' => $seat->id,
                'showtime_id' => $showtime->id,
                'price' => $seat->price,
                'status' => ReservedSeat::STATUS_UNPAID,
            ]);
        });
    }
}
