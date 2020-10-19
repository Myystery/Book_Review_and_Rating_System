<?php

namespace App\Support;

use App\Drivers\Database\DatabaseDriver;

/**
 * Class DB
 * @package App\Support
 *
 * @method bool|\mysqli_result query($query)
 * @method bool|int insert($table, $params, $format)
 * @method bool|\mysqli_result select($table, $select, $where, $where_format, $limit=null, $offset=0)
 * @method bool update($table, $data, $data_format, $where, $where_format)
 * @method bool delete($table, $id)
 * @method bool|\mysqli_result execute($query)
 */
class DB
{
    /** @var DatabaseDriver */
    private $dbDriver;

    /**
     * DB constructor.
     */
    public function __construct()
    {
        $default        = config('database.driver');
        $dbDriver       = config("database.credentials.{$default}");
        $this->dbDriver = new $dbDriver['driver']();
        $this->dbDriver->connect(
            $dbDriver['host'],
            $dbDriver['username'],
            $dbDriver['password'],
            $dbDriver['db_name']
        );
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->dbDriver, $name)) {
            return call_user_func_array([$this->dbDriver, $name], $arguments);
        }

        throw new \Exception("Method does not exist");
    }
}