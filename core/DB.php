<?php

class DB {

    // private $DB_DSN = 'mysql:hostname=localhost;dbname=camagru;unix_socket=/opt/lampp/var/mysql/mysql.sock';
    private $DB_DSN = 'mysql:hostname=localhost;dbname=camagru';
    private $DB_USER = 'root';
    // private $DB_PASSWORD = '';
    private $DB_PASSWORD = '1234567';

    private static $_instance = null;
    private $_pdo;
    private $_query; 
    private $_error = false;
    private $_result;
    private $_count = 0;
    private $_lastInsertID = null;

    private function __construct() {
        try {
            $this->_pdo = new PDO($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($sql, $params = []) {
        $this->_error = false;
    try {
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $count = 1;
            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($count, $param);
                    $count++;
                }
            }
            if ($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastInsertID = $this->_pdo->lastInsertId();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }
    catch (Exception $e) {
        echo $e;
    }

    }

    protected function _read($table, $params = []) {
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';
        if (isset($params['conditions'])) {
            if (is_array($params['conditions'])) {
                foreach ($params['conditions'] as $condition) {
                    $conditionString .= ' ' . $condition . ' AND';
                }
                $conditionString = rtrim(trim($conditionString), ' AND'); 
            } else {
                $conditionString = $params['conditions'];
            }
            if ($conditionString != '') {
                $conditionString = ' WHERE ' . $conditionString;
            }
        }
        if (array_key_exists('bind',$params)) {
            $bind = $params['bind'];
        }
        if (array_key_exists('order',$params)) {
            $order = ' ORDER BY ' .$params['order'];
        }
        if (array_key_exists('limit',$params)) {
            $limit = ' LIMIT ' .$params['limit'];
        }
        $sql = "SELECT * FROM {$table}{$conditionString}{$order}{$limit}";
        if ($this->query($sql, $bind)) {
            if (!count($this->_result)) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function find($table, $params = []) {
       if ($this->_read($table, $params)) {
           return $this->results();
       }
       return false;
    }
    
    public function findFirst($table, $params = []) {
       if ($this->_read($table, $params)) {
           return $this->first();
       }
       return false;
    }
    
    public function insert($table, $fields = []) {
        $fieldString = '';
        $valueString = '';
        $values = [];
        foreach ($fields as $field => $value) {
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');
        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";
        if (!$this->query($sql, $values)->error()) {
            return true;
        }
        return false;
    }

    public function update($table, $id, $fields = []) {

        $fieldString = '';
        $values = [];
        foreach ($fields as $field => $value) {
            $fieldString .= ' ' . $field . '= ?,';
            $values[] = $value;
        }
        $fieldString = rtrim(trim($fieldString), ','); 
        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";
        if (!$this->query($sql, $values)->error()) {
            return true;
        }
        return false;
    }

    public function delete($table, $id) {
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        if (!$this->query($sql)->error()) {
            return true;
        }
        return false;
    }

    public function results() {
        return $this->_result;
    }

    public function first() {
        return (!empty($this->_result[0])) ? $this->_result[0] : [];
    }

    public function count() {
        return $this->_count;
    }

    public function lastId() {
        return $this->_lastInsertID;
    }
    
    public function getColumns($table) {
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }

    public function error() {
        return $this->_error;
    }
}