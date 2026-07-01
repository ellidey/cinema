<?php

namespace Database\Seeders;

use App\Models\ReservedSeat;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReservedSeatSeeder extends Seeder
{
    /**
     * @var array<int, array{showtime: string, hall: string, row: int, number: int, status: string}>
     */
    private array $reservedSeats = [
        [
            'showtime' => '2030-07-01 16:30:00',
            'hall' => 'Зал 1',
            'row' => 1,
            'number' => 1,
            'status' => ReservedSeat::STATUS_PAID,
        ],
        [
            'showtime' => '2030-07-01 16:30:00',
            'hall' => 'Зал 1',
            'row' => 1,
            'number' => 2,
            'status' => ReservedSeat::STATUS_UNPAID,
        ],
        [
            'showtime' => '2030-07-02 20:00:00',
            'hall' => 'Зал IMAX',
            'row' => 2,
            'number' => 3,
            'status' => ReservedSeat::STATUS_PAID,
        ],
    ];

    public function run(): void
    {
        foreach ($this->reservedSeats as $reservationData) {
            $showtime = Showtime::query()
                ->where('starts_at', Carbon::parse($reservationData['showtime']))
                ->whereHas('hall', fn ($query) => $query->where('name', $reservationData['hall']))
                ->firstOrFail();

            $seat = Seat::query()
                ->where('hall_id', $showtime->hall_id)
                ->where('row', $reservationData['row'])
                ->where('number', $reservationData['number'])
                ->firstOrFail();

            ReservedSeat::query()->updateOrCreate(
                [
                    'seat_id' => $seat->id,
                    'showtime_id' => $showtime->id,
                ],
                [
                    'reserved_at' => Carbon::now(),
                    'price' => $seat->price,
                    'status' => $reservationData['status'],
                ],
            );
        }
    }
}
