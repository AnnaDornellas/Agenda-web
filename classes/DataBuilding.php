<?php

namespace System\Classes;

use PDO;
use PDOException;
use PDOStatement;

class DataBuilding {

    private $command = null;
    private $use = null;
    private $lastInsertId = null;
    private $connection = null;
    private $test = true;

    public function __construct($use) {
        if ($use != null) {
            $this->use = $use;
        }
        $this->getInstanceConnection();
        return $this;
    }

    private function getInstanceConnection() {

        $drive = DRIVER;
        $host = HOST;
        $charset = CHARSET;
        $dbname = DATABASE;
        $username = USERNAME;
        $password = PASSWORD;

        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        try {
            $this->connection = new PDO("{$drive}:host={$host};dbname={$dbname};charset={$charset}", $username, $password, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function test() {
        return $this->test;
    }

    public function insertMany($params) {
        foreach ($params as $param) {
            $this->insert($param)->execute();
        }
    }

    public function deleteMany($params) {
        foreach ($params as $param) {
            $this->delete($param)->execute();
        }
    }

    public function distinct() {
        $this->query = str_replace('SELECT', 'SELECT DISTINCT', $this->query);
        return $this;
    }

    public function insert($params) {
        $this->command = 'INSERT';
        $keys = "`" . implode("`,`", array_keys($params)) . "`";
        $refers = ":" . implode(",:", array_keys($params));
        foreach ($params as $key => $value) {
            $this->loopValues[':' . $key] = $value;
        }
        $this->query = trim('INSERT INTO ' . $this->use . ' (' . $keys . ') VALUES (' . $refers . ');');
        return $this;
    }

    public function delete($params = []) {
        $this->command = 'DELETE';
        if ($params == '*') {
            $this->query = trim('DELETE FROM `' . $this->use . '`');
        } else if (sizeof($params) == 0) {
            $this->query = trim('DELETE FROM `' . $this->use . '` WHERE ');
        } else {
            $keys = "`" . implode("`,`", array_keys($params)) . "`";
            $refers = ":" . implode(",:", array_keys($params));
            foreach ($params as $key => $value) {
                $this->loopValues[':' . $key] = $value;
            }
            $this->query = trim('DELETE FROM `' . $this->use . '` WHERE ' . $keys . ' = ' . $refers . ';');
        }


        return $this;
    }

    public function update($params) {
        $this->command = 'UPDATE';
        foreach ($params as $key => $value) {
            $this->loopValues[':' . $key] = $value;
        }
        $refers = null;
        $keys = array_keys($params);
        $size = (sizeof($params) - 1);
        foreach ($keys as $key => $values) {
            if ($size == $key) {
                $refers .= '`' . $values . '`=:' . $values;
            } else {
                $refers .= '`' . $values . '`=:' . $values . ',';
            }
        }

        $this->query = trim('UPDATE `' . $this->use . '` SET ' . $refers . ' WHERE');
        return $this;
    }

    public function select($params = null) {
        $this->command = 'SELECT';
        if ($params == null || $params == '*') {
            $this->query = trim('SELECT * FROM `' . $this->use . '`');
        } else {
            $refers = null;
            $keys = array_values($params);
            $size = (sizeof($params) - 1);
            foreach ($keys as $key => $values) {
                if ($size == $key) {
                    $refers .= '`' . $values . '`';
                } else {
                    $refers .= '`' . $values . '`,';
                }
            }
            $this->query = trim('SELECT ' . $refers . ' FROM `' . $this->use . '` WHERE');
        }
        return $this;
    }

    public function free($query, $typeQuery) {
        $typeQuery = strtoupper($typeQuery);
        if ($typeQuery == 'CREATE') {
            $this->command = 'SELECT';
        } else {
            $this->command = $typeQuery;
        }
        $this->query = $query;
        return $this;
    }

    public function limit($num_rows, $offset) {
        $this->query = $this->query . ' LIMIT ' . $num_rows . ' OFFSET ' . $offset;
        return $this;
    }

    public function orderBy($params, $orderBy) {
        $refers = null;
        $keys = array_values($params);
        $size = (sizeof($params) - 1);

        foreach ($keys as $key => $values) {
            if ($size == $key) {
                $refers .= '`' . $values . '`';
            } else {
                $refers .= '`' . $values . '`,';
            }
        }

        $this->query = $this->query . ' ORDER BY ' . $refers . ' ' . strtoupper($orderBy);
        return $this;
    }

    public function get() {
        if ($this->command == 'SELECT') {
            return $this->rows;
        }
        return false;
    }

    public function escape() {
        $this->query = str_replace('  ', ' ', $this->query);

        if (isset($this->query)) {
            var_dump($this->query);
        }
        if (isset($this->loopValues)) {
            var_dump($this->loopValues);
        }
        die();
    }

    public function in($params) {
        $column = null;
        $values = [];
        $i = 0;
        foreach ($params as $param_name => $param) {
            if ($i == 0) {
                $column = $param_name;
                break;
            }
            $i++;
        }
        $keys = ":number_" . implode(',:number_', array_keys($params[$column]));
        foreach ($params[$column] as $key => $value) {
            $this->loopValues[':number_' . $key] = $value;
        }
        $this->query = trim($this->query . ' `' . $column . '` IN(' . $keys . ')');
        return $this;
    }

    public function notIn($params) {
        $column = null;
        $values = [];
        $i = 0;
        foreach ($params as $param_name => $param) {
            if ($i == 0) {
                $column = $param_name;
                break;
            }
            $i++;
        }
        $keys = ":number_" . implode(',:number_', array_keys($params[$column]));
        foreach ($params[$column] as $key => $value) {
            $this->loopValues[':number_' . $key] = $value;
        }
        $this->query = trim($this->query . ' `' . $column . '` NOT IN(' . $keys . ')');
        return $this;
    }

    public function conditions($params, $logical_operator = '=', $connectives = null) {
        if (sizeof($params) == 1) {
            $keys = "`" . implode("`,`", array_keys($params)) . "`";
            $refers = ":" . implode(",:", array_keys($params));
            foreach ($params as $key => $value) {
                $this->loopValues[':' . $key] = $value;
            }
            if (is_array($logical_operator)) {
                foreach ($logical_operator as $lopr) {
                    $logical = $lopr;
                    break;
                }
            } else {
                $logical = $logical_operator;
            }

            if (!strstr(strtoupper($this->query), 'WHERE')) {
                $this->query = $this->query . ' WHERE ' . $keys . $logical . $refers;
            } else {
                $this->query = $this->query . ' ' . $keys . $logical . $refers;
            }
        } else {
            $keys = array_keys($params);
            $refers = array_keys($params);
            foreach ($params as $key => $value) {
                $this->loopValues[':' . str_replace('^', '_', $key)] = $value;
            }
            $concat = null;
            $size = (sizeof($refers) - 1);
            foreach ($refers as $key => $refer) {

                if (is_array($logical_operator)) {
                    if (isset($logical_operator[$key])) {
                        $logical = $logical_operator[$key];
                    }
                } else {
                    $logical = $logical_operator;
                }
                if ($logical == "" || $logical == null || $logical == false) {
                    $logical = '=';
                }

                if (is_array($connectives)) {
                    if (isset($connectives[$key])) {
                        $connect = $connectives[$key];
                    }
                } else {
                    $connect = $connectives;
                }
                if ($connect == "" || $connect == null || $connect == false) {
                    $connect = 'and';
                }

                if ($size == $key) {
                    $concat .= '`' . str_replace('^', '', $keys[$key]) . '`' . $logical . ':' . str_replace('^', '_', $refer);
                } else {
                    $concat .= '`' . str_replace('^', '', $keys[$key]) . '`' . $logical . ':' . str_replace('^', '_', $refer) . ' ' . strtoupper($connect) . ' ';
                }
            }
            if (!strstr(strtoupper($this->query), 'WHERE')) {
                $this->query = trim($this->query . ' WHERE ' . $concat);
            } else {
                $this->query = trim($this->query . ' ' . $concat);
            }
        }
        return $this;
    }

    public function concat($connectives) {
        $this->query = $this->query . ' ' . strtoupper($connectives);
        return $this;
    }

    public function execute() {
        try {
            $this->query = str_replace('  ', ' ', $this->query);
            $stmt = $this->connection->prepare($this->query);
            if (@$this->loopValues != null) {
                $refers = [];
                foreach ($this->loopValues as $key => $value) {
                    $refers[ltrim($key, ':')] = $value;
                    $refer = ltrim($key, ':');
                    if (@is_nan($value)) {
                        $stmt->bindParam($key, $$refer, PDO::PARAM_INT);
                    } else if (is_string($value)) {
                        $stmt->bindParam($key, $$refer, PDO::PARAM_STR);
                    } else if (is_bool($value)) {
                        $stmt->bindParam($key, $$refer, PDO::PARAM_BOOL);
                    } else if (is_null($value)) {
                        $stmt->bindParam($key, $$refer, PDO::PARAM_NULL);
                    } else {
                        $stmt->bindParam($key, $$refer);
                    }
                }
                unset($this->loopValues);
                foreach ($refers as $refer => $value) {
                    $$refer = $value;
                }
            }


            $result = $stmt->execute();
            if ($this->command == 'SELECT') {
                $this->rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            $this->result($stmt, $result);
        } catch (PDOException $e) {
            $response['execute'] = false;
            $response['messagem'] = 'Number of 0 lines affected.';
            $response['query'] = $this->query;
            $response['PDOException'] = $e->getMessage();
            return $response;
        }
    }

    private function result($stmt, $result) {
        if ($result) {
            $number = $stmt->rowCount();
            if ($stmt->rowCount()) {
                $this->setLastInsertId($this->connection->lastInsertId());
                $stmt->fetch();
                $stmt->closeCursor();
                $stmt = null;
                $response['execute'] = true;
                $response['messagem'] = 'Number of ' . $number . ' lines affected.';
                $response['query'] = $this->query;
                return $response;
            } else {
                $stmt = null;
                $response['execute'] = false;
                $response['messagem'] = 'Number of ' . $number . ' lines affected.';
                $response['query'] = $this->query;
                return $response;
            }
        } else {
            $response['execute'] = false;
            $response['messagem'] = 'Number of 0 lines affected.';
            $response['errorInfo'] = $stmt->errorInfo();
            $response['query'] = $this->query;
            return $response;
        }
    }

    private function setLastInsertId($id) {
        $this->lastInsertId = $id;
    }

    public function getLastInsertId() {
        return $this->lastInsertId;
    }

    public function __destruct() {
        $this->connection = null;
    }

}
