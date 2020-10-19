<?php

use App\Support\Route;

Route::get('/', 'HomeController@index');

// authentication
Route::get('/login', 'AuthController@index');
Route::get('/register', 'AuthController@index');
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/logout', 'AuthController@logout');

// users
Route::get('/users', 'UserController@index');
Route::get('/users/new', 'UserController@create');
Route::post('/users', 'UserController@store');
Route::get('/users/{user}/edit', 'UserController@edit');
Route::post('/users/{user}', 'UserController@update');
Route::post('/users/{user}/delete', 'UserController@delete');
Route::get('/profile', 'UserController@show');

Route::get('/publishers', 'UserController@publishers');
Route::get('/authors', 'UserController@authors');

// categories
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/new', 'CategoryController@create');
Route::post('/categories', 'CategoryController@store');
Route::get('/categories/{category}/edit', 'CategoryController@edit');
Route::post('/categories/{category}', 'CategoryController@update');
Route::post('/categories/{category}/delete', 'CategoryController@delete');

// books (publisher)
Route::get('/publishers/{user}/books', 'BookController@publisherBooks');
Route::get('/books', 'BookController@index');
Route::get('/books/new', 'BookController@create');
Route::post('/books', 'BookController@store');
Route::get('/books/{book}', 'BookController@show');
Route::get('/books/{book}/edit', 'BookController@edit');
Route::post('/books/{book}', 'BookController@update');

// Reviews
Route::post('/books/{book}/reviews', 'ReviewController@store');
Route::post('/books/{book}/reviews/{review}', 'ReviewController@delete');