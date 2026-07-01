<?php

use App\Http\Controllers\Api\HallController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ReservedSeatController;
use App\Http\Controllers\Api\SeatController;
use App\Http\Controllers\Api\ShowtimeController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'cinema-api',
    ]);
});

Route::apiResource('movies', MovieController::class)->only(['index', 'show']);
Route::apiResource('halls', HallController::class)->only(['index', 'show']);
Route::apiResource('seats', SeatController::class)->only(['index', 'show']);
Route::apiResource('showtimes', ShowtimeController::class)->only(['index', 'show']);
Route::apiResource('reserved-seats', ReservedSeatController::class)
    ->only(['index', 'store', 'show'])
    ->parameters(['reserved-seats' => 'reservedSeat']);
Route::patch('/reserved-seats/{reservedSeat}/pay', [ReservedSeatController::class, 'pay']);
