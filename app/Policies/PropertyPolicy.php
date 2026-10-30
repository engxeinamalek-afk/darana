<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function access(User $user, Property $property){
        return $user->id === $property->office_id;
    }
}
