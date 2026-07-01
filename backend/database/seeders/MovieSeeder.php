<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Seeder;
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
        $path = "movies/{$slug}.svg";

        if (Storage::disk('public')->exists($path)) {
            return $path;
        }

        Storage::disk('public')->put($path, $this->makePosterSvg($title));

        return $path;
    }

    private function makePosterSvg(string $title): string
    {
        $escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="600" height="900" viewBox="0 0 600 900" role="img" aria-label="{$escapedTitle}">
  <rect width="600" height="900" fill="#e2e8f0"/>
  <rect x="48" y="48" width="504" height="804" rx="24" fill="#f8fafc" stroke="#94a3b8" stroke-width="3"/>
  <path d="M108 154h384v92H108z" fill="#cbd5e1"/>
  <circle cx="180" cy="390" r="58" fill="#94a3b8"/>
  <circle cx="300" cy="390" r="58" fill="#94a3b8"/>
  <circle cx="420" cy="390" r="58" fill="#94a3b8"/>
  <rect x="134" y="568" width="332" height="18" rx="9" fill="#cbd5e1"/>
  <rect x="168" y="612" width="264" height="18" rx="9" fill="#cbd5e1"/>
  <text x="300" y="760" text-anchor="middle" font-family="Arial, sans-serif" font-size="42" font-weight="700" fill="#334155">{$escapedTitle}</text>
</svg>
SVG;
    }
}
