<?php

namespace App\Support;

class Storage
{
    /**
     * @param $path
     *
     * @return string
     */
    public function path($path)
    {
        return base_dir('storage') . $path;
    }

    public function base_dir()
    {
        $doc_root    = $_SERVER['DOCUMENT_ROOT'];
        $script_path = $_SERVER['SCRIPT_FILENAME'];
        $script_name = $_SERVER['SCRIPT_NAME'];

        if ($doc_root === "") {
            return realpath(dirname(__FILE__) . '../../../');
        }

        return $doc_root . rtrim(ltrim($script_path, $doc_root), $script_name);
    }

    public function delete($path)
    {
        if (file_exists($this->base_dir() . $path)) {
            unlink($this->base_dir() . $path);
        }
    }
}