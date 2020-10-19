<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param $params
     *
     * @return User|object|\stdClass
     * @throws \Exception
     */
    public function store($params)
    {
        if (User::exists(['email' => $params['email']])) {
            throw new \Exception("This email has already been used.");
        }

        $params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);

        /** @var User $user */
        return User::create($params);
    }
}