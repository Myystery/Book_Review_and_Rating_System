<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Review $review
     *
     * @return bool
     */
    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id;
    }
}