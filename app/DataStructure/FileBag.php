<?php

namespace App\DataStructure;

use Exception;

class FileBag
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @param $storage_path
     *
     * @return string|null
     * @throws Exception
     */
    public function move($storage_path)
    {
        if ( ! file_exists(dirname($storage_path))) {
            throw new Exception("Path {$storage_path} does not exist");
        }

        if (move_uploaded_file($this->file['tmp_name'], $storage_path)) {
            return $storage_path;
        }

        throw new Exception("Could not move file");
    }

    /**
     * @param string $path
     *
     * @return bool
     * @throws Exception
     */
    public function store($path = '')
    {
        if ($storage_path = $this->move(storage_path($path) . $this->hashName())) {
            return str_replace(base_dir(), '/', $storage_path);
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function hashName()
    {
        return sha1($this->file['name'] . time()) . '.' . pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }
}
