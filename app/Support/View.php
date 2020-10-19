<?php

namespace App\Support;

use App\Exceptions\ViewNotFoundException;

class View
{
    private $view;
    private $args;
    private static $globals = [];
    /** @var View */
    private static $masterLayout;

    /**
     * View constructor.
     *
     * @param $path
     *
     * @param $args
     *
     * @throws ViewNotFoundException
     */
    public function __construct($path, $args = [])
    {
        $view_path = base_dir('views') . str_replace('.', '/', $path) . '.php';
        if ( ! file_exists($view_path)) {
            throw new ViewNotFoundException("View file {$view_path} not found.");
        }

        $this->view = $view_path;
        $this->args = $args;
    }

    /**
     * @param View $view
     */
    public static function setMasterLayout(View $view)
    {
        static::$masterLayout = $view;
    }

    /**
     * @param $args
     */
    public function addArgs($args = [])
    {
        $this->args = array_merge($this->args, $args);
    }

    /**
     * @param $key
     * @param $value
     */
    public static function addParam($key, $value)
    {
        static::$globals[$key] = $value;
    }

    /**
     * @param array $pairs
     */
    public static function addParams($pairs = [])
    {
        static::$globals = array_merge(static::$globals, $pairs);
    }

    /**
     *
     */
    public function render()
    {
        if ( ! static::$masterLayout) {
            die("Master layout not set");
        }

        $content = $this->getRenderedContent();

        static::$masterLayout->addArgs(['content' => $content]);

        echo static::$masterLayout->getRenderedContent();
    }

    /**
     * @return false|string
     */
    private function getRenderedContent()
    {
        $allArgs = array_merge(static::$globals, $this->args);
        foreach ($allArgs as $key => $arg) {
            ${$key} = $arg;
        }

        ob_start();

        include $this->view;

        return ob_get_clean();
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return $this->getRenderedContent();
    }
}
