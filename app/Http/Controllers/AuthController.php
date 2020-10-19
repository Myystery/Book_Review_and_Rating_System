<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Support\Session;

class AuthController
{
    /**
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function index()
    {
        redirectIfAuthenticated();

        return view('auth.auth');
    }

    /**
     * @return \App\Support\Redirect
     */
    public function login()
    {
        redirectIfAuthenticated();

        $email    = request()->get('email');
        $password = request()->get('password');

        if (auth()->attempt($email, $password)) {
            return redirect('/');
        }
        Session::set('msg', 'Invalid email/password');

        return redirect()->back()->with(['email']);
    }

    /**
     *
     */
    public function register()
    {
        redirectIfAuthenticated();

        $userRepository = new UserRepository();
        try {
            $user = $userRepository->store(request()->only(['name', 'email', 'password', 'role', 'location']));
            auth()->login($user);

            return redirect('/');
        } catch (\Exception $e) {
            Session::set('msg', $e->getMessage());

            return redirect()->back()->with(request()->only(['name', 'email']));
        }
    }

    /**
     * @return \App\Support\Redirect
     */
    public function logout()
    {
        redirectIfNotAuthenticated();

        auth()->logout();

        return redirect()->route('/login');
    }
}
