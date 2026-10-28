<?php

namespace App\Scopes;

use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AvailableScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', PropertyStatus::AVAILABLE);
    }
}
