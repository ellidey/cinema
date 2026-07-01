<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class MovieBuilder extends Builder
{
    public function orderedByTitle(): self
    {
        return $this->orderBy('title');
    }
}
