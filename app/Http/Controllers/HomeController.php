<?php

namespace App\Http\Controllers;

class HomeController
{
    public function __construct()
    {

    }

    /**
     * @return \App\Support\View
     * @throws \App\Exceptions\ViewNotFoundException
     */
    public function index()
    {
        return view('home.welcome', ['name' => 'Rocky']);
    }
}
