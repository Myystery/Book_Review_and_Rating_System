<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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

    /**
     * @param User $user
     * @param User $target
     *
     * @return bool
     */
    public function view(User $user, User $target)
    {
        return $user->id === $target->id;
    }

    /**
     * @param User $user
     * @param User $target
     *
     * @return bool
     */
    public function edit(User $user, User $target)
    {
        return $user->id === $target->id;
    }
}
