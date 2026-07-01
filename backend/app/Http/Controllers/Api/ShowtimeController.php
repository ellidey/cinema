<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowtimeResource;
use App\Models\Showtime;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShowtimeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $showtimes = Showtime::query()
            ->withApiRelations()
            ->orderedByStart()
            ->get();

        return ShowtimeResource::collection($showtimes);
    }

    public function show(Showtime $showtime): ShowtimeResource
    {
        return new ShowtimeResource($showtime->load(['movie', 'hall'])->loadCount('reservedSeats'));
    }
}
