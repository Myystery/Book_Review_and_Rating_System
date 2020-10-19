<?php

use App\DataStructure\Collection;
use App\Services\SingletonService;
use App\Support\Request;
use App\Support\Response;

function app($alias = null)
{
    /** @var SingletonService $singleton */
    $singleton = SingletonService::Instance();

    if ( ! $alias) {
        return $singleton;
    }

    return $singleton->get($alias);
}

/**
 * @param null $content
 *
 * @return Response
 */
function response($content = null)
{
    return new Response($content);
}

/**
 * @return Request
 */
function request()
{
    return app('request');
}

/**
 * @param array $array
 *
 * @return Collection
 */
function collect($array = [])
{
    return new Collection($array);
}

/**
 * @param $path
 *
 * @return mixed|null
 */
function config($path = null)
{
    /** @var \App\Support\Config $config */
    $config = app('config');

    return $config->get($path);
}

function route($url)
{
    return $url;
}

/**
 * @param $path
 *
 * @param array $args
 *
 * @return \App\Support\View
 * @throws \App\Exceptions\ViewNotFoundException
 */
function view($path, $args = [])
{
    return new \App\Support\View($path, $args);
}

/**
 * @return \App\Support\Storage
 */
function storage()
{
    return app('storage');
}

/**
 * @param $path
 *
 * @return string
 */
function storage_path($path)
{
    return base_dir('storage') . rtrim($path, '/') . '/';
}

/**
 * @param string $path
 *
 * @return string
 */
function base_dir($path = null)
{
    return storage()->base_dir() . '/' . ($path ? trim($path, '/') . '/' : null);
}

function redirect($url = null)
{
    return new \App\Support\Redirect($url);
}

function old($key, $default = null)
{
    $val = \App\Support\Session::get($key, $default);
    \App\Support\Session::forget($key);

    return $val;
}

/**
 * @return \App\Support\Auth
 */
function auth()
{
    return app('auth');
}

/**
 * @return \App\Support\Cookie
 */
function cookie()
{
    return app('cookie');
}

function dd($print_backtrace = false)
{
    if ($print_backtrace) {
        ob_start();

        debug_print_backtrace();

        $debug = ob_get_clean();

        print "<div style='border: 1px solid; margin: 2px;'><pre>";
        echo $debug;
        print "</pre></div>";
    }

    foreach (func_get_args() as $func_arg) {
        print "<div style='border: 1px solid; margin: 2px;'>";
        var_dump($func_arg);
        print "</div>";
    }
    die;
}

function str_random($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

/**
 * @param $text
 *
 * @return false|string|string[]|null
 */
function str_slug($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * @param string $url
 */
function redirectIfAuthenticated($url = '/')
{
    if (auth()->check()) {
        redirect($url);
        die;
    }
}

/**
 * @param string $url
 */
function redirectIfNotAuthenticated($url = '/')
{
    if ( ! auth()->check()) {
        redirect($url);
        die;
    }
}

/**
 * @param $file
 */
function resize_image($file)
{
    $img = new \App\Support\Image();
    $img->load($file);
    $img->resizeToWidth(250);
    $img->save($file);
}

//========================== model helpers

/**
 * @return \App\Models\User[]
 */
function authors()
{
    return \App\Models\User::select(['role' => 'author']);
}

/**
 * @return \App\Models\User[]
 */
function publishers()
{
    return \App\Models\User::select(['role' => 'publisher']);
}

/**
 * @param null $l
 *
 * @return \App\Models\Category[]
 */
function categories($l = null)
{
    return \App\Models\Category::select([], ['*'], $l);
}

/**
 * @param $str
 *
 * @return string
 */
function p($str)
{
    return '<p>'
           . implode('</p><p>', explode(PHP_EOL, str_replace(['\r\n', '\n'], PHP_EOL, htmlspecialchars($str))))
           . '</p>';
}

/**
 * @param null $id
 *
 * @return \App\Models\Book[]
 */
function monthly_top($id = null)
{
    /** @var \App\Support\DB $db */
    $db = app('db');

    $date_string = date('Y-m-d') . ' first day of last month';
    $dt          = date_create($date_string);
    $date        = $dt->format('Y-m-d');

    if ($id !== null) {
        $db->query("INSERT INTO monthly_top (book_id, added_for) VALUES ({$id}, '{$date}')");

        return;
    }
    $results = $db->query("SELECT books.* from books INNER JOIN monthly_top ON monthly_top.book_id = books.id WHERE monthly_top.added_for = '{$date}'");
    $books = [];
    while ($book = $results->fetch_object(\App\Models\Book::class)) {
        $books[] = $book;
    }

    return $books;
}
