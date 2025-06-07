<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;

class LikePolicy
{
    /**
     * Determina si el usuario puede crear un like.
     */
    public function create(?User $user): bool
    {
        return $user !== null;
    }
}
