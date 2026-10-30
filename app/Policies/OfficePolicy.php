<?php

namespace App\Policies;

use App\Models\User;

class OfficePolicy
{
    public function access(User $user, User $office){
        return $user->id === $office->id;
    }
}
