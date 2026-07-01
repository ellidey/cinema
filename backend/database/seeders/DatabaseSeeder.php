<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MovieSeeder::class,
            HallSeeder::class,
            SeatSeeder::class,
            ShowtimeSeeder::class,
            ReservedSeatSeeder::class,
        ]);
    }
}
