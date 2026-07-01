<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    /**
     * @var array<int, array{title: string, description: string, duration: int}>
     */
    private array $movies = [
        [
            'title' => 'Arrival',
            'description' => 'Лингвист помогает военным установить контакт с инопланетной цивилизацией.',
            'duration' => 116,
        ],
        [
            'title' => 'The Grand Budapest Hotel',
            'description' => 'История легендарного консьержа и его юного помощника в отеле между войнами.',
            'duration' => 99,
        ],
        [
            'title' => 'Dune: Part Two',
            'description' => 'Пол Атрейдес объединяется с фременами и принимает судьбу на Арракисе.',
            'duration' => 166,
        ],
        [
            'title' => 'Interstellar',
            'description' => 'Группа исследователей отправляется сквозь червоточину в поисках нового дома для человечества.',
            'duration' => 169,
        ],
        [
            'title' => 'Knives Out',
            'description' => 'Частный детектив расследует смерть главы богатой и крайне конфликтной семьи.',
            'duration' => 130,
        ],
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('movies');

        foreach ($this->movies as $movieData) {
            $imagePath = $this->downloadPoster($movieData['title']);

            Movie::query()->updateOrCreate(
                ['title' => $movieData['title']],
                [
                    'image' => $imagePath,
                    'description' => $movieData['description'],
                    'duration' => $movieData['duration'],
                ],
            );
        }
    }

    private function downloadPoster(string $title): string
    {
        $slug = Str::slug($title);
        $path = "movies/{$slug}.jpg";

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        $response = Http::timeout(20)->get("https://picsum.photos/seed/{$slug}/600/900.jpg");
        $response->throw();

        Storage::disk('public')->put($path, $response->body());

        return $path;
    }
}
