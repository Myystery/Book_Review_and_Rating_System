<?php

namespace App\DataStructure;

use Countable;
use Iterator;

class Collection implements Countable, Iterator
{
    private $items = [];
    private $count = 0;
    private $cursor = 0;

    public function __construct($array = [])
    {
        $this->items = $array;
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->key()];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->cursor;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return array_keys($this->items)[$this->cursor];
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->cursor < $this->count();
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->cursor = 0;
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return $this->count;
    }

    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    public function merge(array $array, $return = false)
    {
        if ( ! $return) {
            $this->items = array_merge($this->items, $array);

            return $this;
        }

        return new Collection(array_merge($this->items, $array));
    }

    public function remove($key)
    {
        unset($this->items[$key]);
    }

    public function map($callback)
    {
        $this->items = array_map($callback, $this->items);

        return $this;
    }

    public function filter($callback)
    {
        $this->items = array_filter($this->items, $callback);

        return $this;
    }

    public function only($keys)
    {
        return array_filter(array_filter($this->items, function ($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY), function ($value) {
            return $value !== null;
        });
    }

    public function toArray()
    {
        return $this->items;
    }

    public function __toString()
    {
        $str = "<pre>";
        $str .= print_r($this->items, 1);
        $str .= "</pre>";

        return $str;
    }
}
