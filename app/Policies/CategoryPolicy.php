<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    /**
     * @param User $user
     *
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}