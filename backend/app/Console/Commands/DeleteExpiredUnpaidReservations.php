<?php

namespace App\Console\Commands;

use App\Models\ReservedSeat;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteExpiredUnpaidReservations extends Command
{
    protected $signature = 'cinema:delete-expired-unpaid-reservations';

    protected $description = 'Delete unpaid reservations after configured TTL.';

    public function handle(): int
    {
        $ttlSeconds = max(1, (int) config('cinema.unpaid_reservation_ttl_seconds'));
        $expiresBefore = Carbon::now()->subSeconds($ttlSeconds);

        $deletedCount = ReservedSeat::query()
            ->where('status', ReservedSeat::STATUS_UNPAID)
            ->where('reserved_at', '<=', $expiresBefore)
            ->delete();

        $this->info("Deleted expired unpaid reservations: {$deletedCount}");

        return self::SUCCESS;
    }
}
