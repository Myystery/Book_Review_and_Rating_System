<?php

namespace App\Http\Controllers;

use App\Exceptions\ViewNotFoundException;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Support\Redirect;
use App\Support\Session;
use App\Support\View;
use Exception;

class UserController
{
    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function index()
    {
        auth()->user()->authorize('index', User::class);

        $users = User::paginate();

        return view('users.index', ['users' => $users]);
    }

    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function publishers()
    {
        $users = User::select(['role' => 'publisher']);

        return view('users.users', ['users' => $users, 'hook' => 'publisher']);
    }

    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function authors()
    {
        $users = User::select(['role' => 'author']);

        return view('users.users', ['users' => $users, 'hook' => 'author']);
    }

    /**
     * @return View
     * @throws ViewNotFoundException
     */
    public function create()
    {
        auth()->user()->authorize('create', User::class);

        return view('users.create', ['user' => new User()]);
    }

    /**
     * @return Redirect
     */
    public function store()
    {
        auth()->user()->authorize('create', User::class);

        $name     = request()->get('name');
        $email    = request()->get('email');
        $password = request()->get('password');
        $role     = request()->get('role');
        $location = request()->get('location');
        $photo    = request()->file('photo');

        $userRepository = new UserRepository();
        try {
            $photo_path = $photo ? $photo->store('images') : null;
            $userRepository->store([
                'name'     => $name,
                'slug'     => str_slug($name) . '-' . crc32(str_random(5)),
                'email'    => $email,
                'password' => $password,
                'role'     => $role,
                'location' => $location,
                'photo'    => $photo_path,
            ]);

            return redirect()->route('/users');
        } catch (Exception $e) {
            Session::set('msg', $e->getMessage());

            return redirect()->back()->with(request()->only(['name', 'email', 'role']));
        }
    }

    /**
     * @param User $user
     *
     * @return View
     * @throws ViewNotFoundException
     */
    public function show(User $user = null)
    {
        if ( ! $user) {
            $user = auth()->user();
        }

        auth()->user()->authorize('view', $user);

        return view('users.show', ['user' => $user]);
    }

    /**
     * @param User $user
     *
     * @return View
     * @throws ViewNotFoundException
     */
    public function edit(User $user)
    {
        auth()->user()->authorize('edit', $user);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * @param User $user
     *
     * @return Redirect
     */
    public function update(User $user)
    {
        auth()->user()->authorize('edit', $user);

        $updates = [];

        $name     = request()->get('name');
        $email    = request()->get('email');
        $password = request()->get('password');
        $role     = request()->get('role');
        $location = request()->get('location');
        $photo    = request()->file('photo');

        if ($name) {
            $updates['name'] = $name;
            $updates['slug'] = str_slug($name) . '-' . crc32(str_random(5));
        }
        if ($email) {
            $updates['email'] = $email;
        }
        if ($password) {
            $updates['password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        if ($role && auth()->user()->isAdmin()) {
            $updates['role'] = $role;
        }
        if ($location) {
            $updates['location'] = $location;
        }

        if ($photo) {
            try {
                storage()->delete($user->photo);

                $path             = $photo->store('images');
                $updates['photo'] = $path;

            } catch (Exception $e) {
                Session::set('msg', 'Could not save file. Reason: ' . $e->getMessage());

                return redirect()->back()->with(request()->all()->toArray());
            }
        }

        $user->update($updates);

        Session::set('msg', 'Update successful.');

        return redirect()->back();
    }

    /**
     * @param User $user
     *
     * @return Redirect
     */
    public function delete(User $user)
    {
        $user->delete();

        return redirect()->route('/users');
    }
}
