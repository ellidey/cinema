<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * @var array<int, string>
     */
    private array $halls = [
        'Зал 1',
        'Зал 2',
        'Зал IMAX',
    ];

    public function run(): void
    {
        foreach ($this->halls as $hallName) {
            Hall::query()->firstOrCreate([
                'name' => $hallName,
            ]);
        }
    }
}
