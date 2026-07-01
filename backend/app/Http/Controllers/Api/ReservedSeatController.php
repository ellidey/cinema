<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateReservedSeatAction;
use App\Actions\PayReservedSeatAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexReservedSeatRequest;
use App\Http\Requests\StoreReservedSeatRequest;
use App\Http\Resources\ReservedSeatResource;
use App\Models\ReservedSeat;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservedSeatController extends Controller
{
    public function index(IndexReservedSeatRequest $request): AnonymousResourceCollection
    {
        $reservedSeats = ReservedSeat::query()
            ->withApiRelations()
            ->forShowtime($request->validated('showtime_id'))
            ->withStatus($request->validated('status'))
            ->latestReserved()
            ->get();

        return ReservedSeatResource::collection($reservedSeats);
    }

    public function store(
        StoreReservedSeatRequest $request,
        CreateReservedSeatAction $createReservedSeat,
    ): ReservedSeatResource {
        $reservedSeat = $createReservedSeat->execute(
            $request->integer('seat_id'),
            $request->integer('showtime_id'),
        );

        return new ReservedSeatResource($reservedSeat->loadApiRelations());
    }

    public function show(ReservedSeat $reservedSeat): ReservedSeatResource
    {
        return new ReservedSeatResource($reservedSeat->loadApiRelations());
    }

    public function pay(ReservedSeat $reservedSeat, PayReservedSeatAction $payReservedSeat): ReservedSeatResource
    {
        $reservedSeat = $payReservedSeat->execute($reservedSeat);

        return new ReservedSeatResource($reservedSeat->loadApiRelations());
    }
}
