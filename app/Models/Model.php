<?php

namespace App\Models;

use App\Support\DB;

/**
 * Class Model
 * @package App\Models
 *
 * @property int id
 */
abstract class Model
{
    protected static $cache = [];
    protected static $table;
    protected static $formats;

    /**
     * @param $params
     *
     * @return object|\stdClass
     */
    public static function create($params)
    {
        /** @var DB $db */
        $db = app('db');

        $format = static::getFormat($params);

        $id = $db->insert(static::$table, $params, $format);

        if ($id < 0) {
            return null;
        }

        $result = $db->select(static::$table, ['*'], ['id' => $id], ['i']);

        return $result->fetch_object(static::class);
    }

    /**
     * @param $params
     *
     * @return bool
     */
    public function update($params)
    {
        if ($this->id) {
            /** @var DB $db */
            $db = app('db');

            $params = array_filter($params, function ($value) {
                return $value !== null;
            });

            $format = static::getFormat($params);

            $result = $db->update(static::$table, $params, $format, ['id' => $this->id], ['i']);
            if ($result) {
                foreach ($params as $key => $value) {
                    $this->{$key} = $value;
                }
            }

            return $result;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        if ($this->id) {
            /** @var DB $db */
            $db = app('db');

            $deleted = $db->delete(static::$table, $this->id);
            if ($deleted && method_exists($this, 'deleted')) {
                $this->{'deleted'}();
            }

            return $deleted;
        }

        return false;
    }

    /**
     * @param $params
     *
     * @return bool
     */
    public static function exists($params)
    {
        /** @var DB $db */
        $db = app('db');

        $format = static::getFormat($params);

        return $db->select(static::$table, ['id'], $params, $format)->num_rows > 0;
    }

    /**
     * @param $params
     *
     * @return object|\stdClass
     */
    public static function find($params)
    {
        $key = static::$table . json_encode($params);
        if (array_key_exists($key, static::$cache)) {
            return static::$cache[$key];
        }

        /** @var DB $db */
        $db = app('db');

        $format = static::getFormat($params);

        $result = $db->select(static::$table, ['*'], $params, $format);
        if ($result->num_rows) {
            static::$cache[$key] = $result->fetch_object(static::class);

            return static::$cache[$key];
        }

        return null;
    }

    /**
     * @param $where
     *
     * @param array $fields
     *
     * @param null $limit
     * @param int $offset
     *
     * @return array
     */
    public static function select($where, $fields = ['*'], $limit = null, $offset = 0)
    {
        /** @var DB $db */
        $db = app('db');

        $format = static::getFormat($where);

        $result  = $db->select(static::$table, $fields, $where, $format, $limit, $offset);
        $results = [];
        while ($row = $result->fetch_object(static::class)) {
            $results[] = $row;
        }

        return $results;
    }

    /**
     * @return array
     */
    public static function paginate()
    {
        return static::select([], ['*'], 10, 10 * (request()->get('page', 1) - 1));
    }

    /**
     * @param $params
     *
     * @return array
     */
    private static function getFormat($params)
    {
        $format = [];
        foreach (array_keys($params) as $key) {
            $format[] = isset(static::$formats[$key]) ? static::$formats[$key] : 's';
        }

        return $format;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        return null;
    }

    /**
     * @param $query
     *
     * @return bool|\mysqli_result
     */
    public static function query($query)
    {
        /** @var DB $db */
        $db = app('db');

        return $db->query($query);
    }
}
