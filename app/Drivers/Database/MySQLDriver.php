<?php

namespace App\Drivers\Database;

class MySQLDriver extends DatabaseDriver
{
    /**
     * @param $query
     *
     * @return bool|\mysqli_result
     */
    public function query($query)
    {
        return $this->db->query($query);
    }

    /**
     * @param $table
     * @param $data
     * @param $format
     *
     * @return bool|int
     * @throws \Exception
     */
    public function insert($table, $data, $format)
    {
        if (empty($table) || empty($data)) {
            return false;
        }
        $data   = (array)$data;
        $format = (array)$format;
        $format = implode('', $format);
        $format = str_replace('%', '', $format);
        list($fields, $placeholders, $values) = $this->prep_query($data);
        array_unshift($values, $format);
        $stmt = $this->db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");
        call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($values));
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return $this->db->insert_id;
        } else {
            dd($data, $this->db->error);
            throw new \Exception($this->db->error);
        }
    }

    /**
     * @param $table
     * @param $data
     * @param $format
     * @param $where
     * @param $where_format
     *
     * @return bool
     */
    public function update($table, $data, $format, $where, $where_format)
    {
        if (empty($table) || empty($data)) {
            return false;
        }
        $data   = (array)$data;
        $format = (array)$format;

        $format       = implode('', $format);
        $format       = str_replace('%', '', $format);
        $where_format = implode('', $where_format);
        $where_format = str_replace('%', '', $where_format);
        $format       .= $where_format;

        list($fields, $placeholders, $values) = $this->prep_query($data, 'update');
        $where_clause = '';
        $where_values = [];
        $count        = 0;
        foreach ($where as $field => $value) {
            if ($count > 0) {
                $where_clause .= ' AND ';
            }
            $where_clause   .= $field . '=?';
            $where_values[] = $value;
            $count++;
        }
        array_unshift($values, $format);
        $values = array_merge($values, $where_values);
        $stmt   = $this->db->prepare("UPDATE {$table} SET {$placeholders} WHERE {$where_clause}");
        call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($values));
        $stmt->execute();
        if ($stmt->affected_rows) {
            return true;
        }

        return false;
    }

    /**
     * @param $table
     * @param $select
     * @param $where
     * @param $where_format
     *
     * @param null $limit
     * @param int $offset
     *
     * @return bool|\mysqli_result
     */
    public function select($table, $select, $where, $where_format, $limit = null, $offset = 0)
    {
        $selects      = implode(',', $select);
        $query        = "SELECT {$selects} FROM {$table}";
        $where_keys   = array_keys($where);
        $where_length = count($where_keys);
        if ($where_length > 0) {
            $where_params = [];
            $i            = 0;

            do {
                $where_params[] = $where_keys[$i] . '=?';
            } while (++$i < $where_length);

            $query .= ' WHERE ' . implode(' AND ', $where_params);
        }
        if ($limit) {
            $query          .= " LIMIT ? OFFSET ?";
            $where[]        = $limit;
            $where[]        = $offset;
            $where_format[] = 'i';
            $where_format[] = 'i';
        }
        $stmt = $this->db->prepare($query);
        if ( ! $stmt) {
            dd($this->db->error, $query, func_get_args());
        }
        if (count($where)) {
            $format = implode('', $where_format);
            $format = str_replace('%', '', $format);
            array_unshift($where, $format);
            call_user_func_array(array($stmt, 'bind_param'), $this->ref_values($where));
        }
        $stmt->execute();

        return $stmt->get_result();
    }

    /**
     * @param $table
     * @param $id
     *
     * @return bool
     */
    public function delete($table, $id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$table} WHERE ID = ?");
        $stmt->bind_param('d', $id);
        $stmt->execute();
        if ($stmt->affected_rows) {
            return true;
        }
    }

    /**
     *
     */
    public function disconnect()
    {
        if ($this->db) {
            $this->db->close();
        }
    }

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $db_name
     */
    public function connect($host, $user, $pass, $db_name)
    {
        try {
            $this->db = new \MySQLi($host, $user, $pass, $db_name);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
     * @param $data
     * @param string $type
     *
     * @return array
     */
    private function prep_query($data, $type = 'insert')
    {
        $fields       = '';
        $placeholders = '';
        $values       = array();
        foreach ($data as $field => $value) {
            $fields   .= "{$field},";
            $values[] = $value;
            if ($type == 'update') {
                $placeholders .= $field . '=?,';
            } else {
                $placeholders .= '?,';
            }
        }
        $fields       = substr($fields, 0, -1);
        $placeholders = substr($placeholders, 0, -1);

        return array($fields, $placeholders, $values);
    }

    /**
     * @param $array
     *
     * @return array
     */
    private function ref_values($array)
    {
        $refs = array();
        foreach ($array as $key => $value) {
            $refs[$key] = &$array[$key];
        }

        return $refs;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * @param $query
     *
     * @return bool|\mysqli_result
     */
    public function execute($query)
    {
        return $this->query($query);
    }
}
