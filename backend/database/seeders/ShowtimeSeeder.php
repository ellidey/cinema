<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ShowtimeSeeder extends Seeder
{
    /**
     * @var array<int, array{movie: string, hall: string, starts_at: string}>
     */
    private array $showtimes = [
        ['movie' => 'Arrival', 'hall' => 'Зал 1', 'starts_at' => '2030-07-01 16:30:00'],
        ['movie' => 'Arrival', 'hall' => 'Зал 2', 'starts_at' => '2030-07-01 19:30:00'],
        ['movie' => 'The Grand Budapest Hotel', 'hall' => 'Зал 1', 'starts_at' => '2030-07-02 16:30:00'],
        ['movie' => 'Dune: Part Two', 'hall' => 'Зал IMAX', 'starts_at' => '2030-07-02 20:00:00'],
        ['movie' => 'Interstellar', 'hall' => 'Зал IMAX', 'starts_at' => '2030-07-03 18:00:00'],
        ['movie' => 'Knives Out', 'hall' => 'Зал 2', 'starts_at' => '2030-07-03 21:00:00'],
    ];

    public function run(): void
    {
        foreach ($this->showtimes as $showtimeData) {
            $movie = Movie::query()->where('title', $showtimeData['movie'])->firstOrFail();
            $hall = Hall::query()->where('name', $showtimeData['hall'])->firstOrFail();
            $startsAt = Carbon::parse($showtimeData['starts_at']);

            Showtime::query()->updateOrCreate(
                [
                    'starts_at' => $startsAt,
                    'hall_id' => $hall->id,
                ],
                [
                    'movie_id' => $movie->id,
                    'hall_id' => $hall->id,
                    'starts_at' => $startsAt,
                ],
            );
        }
    }
}
