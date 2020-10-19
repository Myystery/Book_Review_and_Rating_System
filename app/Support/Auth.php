<?php

namespace App\Support;

use App\Models\User;

class Auth
{
    private $auth;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        $this->auth = new \stdClass;
        /** @var User $user */
        $user = null;
        if (Session::has('auth_id')) {
            $user = User::find(['id' => Session::get('auth_id')]);
        } elseif (cookie()->has('remember_token')) {
            $user = User::find(['remember_token' => cookie()->get('remember_token')]);
        }

        if ($user) {
            $this->authorize($user);
        }
    }

    /**
     * @return bool
     */
    public function check()
    {
        return isset($this->auth->user);
    }

    /**
     * @return User|null
     */
    public function user()
    {
        if ( ! $this->check()) {
            return new User();
        }

        return $this->auth->user;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        if ( ! $this->check()) {
            return null;
        }

        return $this->auth->user->id;
    }

    /**
     * @param User $user
     */
    public function login(User $user)
    {
        $this->authorize($user);
    }

    /**
     * @param $email
     * @param $password
     *
     * @return bool
     */
    public function attempt($email, $password)
    {
        /** @var User $user */
        $user = User::find(['email' => $email]);

        if ($user && password_verify($password, $user->password)) {
            $this->authorize($user);

            return true;
        }

        return false;
    }

    /**
     * @param User $user
     */
    private function authorize(User $user)
    {
        $this->auth->user = $user;
        $user->update(['remember_token' => str_random(60)]);
        if ( ! cookie()->has('remember_token') || cookie()->get('remember_token') !== $user->remember_token) {
            cookie()->set('remember_token', $user->remember_token, 60 * 24 * 30);
        }
        Session::set('auth_id', $this->id());
    }

    /**
     *
     */
    public function logout()
    {
        $this->user()->update(['remember_token' => str_random(60)]);
        cookie()->forget('remember_token');
        session_destroy();
        $this->auth = new \stdClass();
    }
}
