<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class HallBuilder extends Builder
{
    public function withListData(): self
    {
        return $this
            ->withCount(['seats', 'showtimes'])
            ->orderBy('name');
    }
}
