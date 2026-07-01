<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HallResource;
use App\Models\Hall;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HallController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $halls = Hall::query()->withListData()->get();

        return HallResource::collection($halls);
    }

    public function show(Hall $hall): HallResource
    {
        $hall->load(['seats' => fn ($query) => $query->orderedForHall()])
            ->loadCount(['seats', 'showtimes']);

        return new HallResource($hall);
    }
}
