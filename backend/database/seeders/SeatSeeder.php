<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        Hall::query()->each(function (Hall $hall): void {
            foreach (range(1, 3) as $row) {
                foreach (range(1, 5) as $number) {
                    Seat::query()->updateOrCreate(
                        [
                            'hall_id' => $hall->id,
                            'row' => $row,
                            'number' => $number,
                        ],
                        [
                            'name' => "{$row}-{$number}",
                            'price' => $this->priceFor($hall->name, $row),
                        ],
                    );
                }
            }
        });
    }

    private function priceFor(string $hallName, int $row): int
    {
        $basePrice = $hallName === 'Зал IMAX' ? 700 : 450;

        return $basePrice + (($row - 1) * 50);
    }
}
