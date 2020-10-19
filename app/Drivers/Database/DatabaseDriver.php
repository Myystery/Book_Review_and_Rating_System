<?php

namespace App\Drivers\Database;

use mysqli;

abstract class DatabaseDriver
{
    /** @var mysqli */
    protected $db;

    abstract public function connect($host, $user, $pass, $db_name);

    abstract public function query($query);

    abstract public function execute($query);

    /**
     * @param $table
     * @param $select
     * @param $where
     * @param $where_format
     *
     * @return \mysqli_result
     */
    abstract public function select($table, $select, $where, $where_format);

    abstract public function insert($table, $data, $format);

    abstract public function update($table, $data, $format, $where, $where_format);

    abstract public function delete($table, $id);

    abstract public function disconnect();
}
