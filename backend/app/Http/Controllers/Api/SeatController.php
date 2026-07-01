<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexSeatRequest;
use App\Http\Resources\SeatResource;
use App\Models\Seat;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeatController extends Controller
{
    public function index(IndexSeatRequest $request): AnonymousResourceCollection
    {
        $seats = Seat::query()
            ->withHall()
            ->forHall($request->validated('hall_id'))
            ->orderedForHall()
            ->get();

        return SeatResource::collection($seats);
    }

    public function show(Seat $seat): SeatResource
    {
        return new SeatResource($seat->load('hall'));
    }
}
