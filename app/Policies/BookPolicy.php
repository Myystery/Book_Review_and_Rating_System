<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
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
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isPublisher();
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return bool
     */
    public function view(User $user, Book $book)
    {
        return true;
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return bool
     */
    public function update(User $user, Book $book)
    {
        return $user->isPublisher() && $user->id === $book->publisher_id;
    }

    /**
     * @param User $user
     * @param Book $book
     *
     * @return bool
     */
    public function delete(User $user, Book $book)
    {
        return $user->isPublisher() && $user->id === $book->publisher_id;
    }

    public function has(User $user)
    {
        return $user->isPublisher() || $user->isAuthor();
    }
}
