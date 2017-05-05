<?php

namespace Database\PDO;

use \PDO;
use \PDOException;

class SQL extends PDO
{

    private $host, $port, $base, $user, $pass, $charset;

    protected function connect()
    {
        try {
            $options = $this->charset ? array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$this->charset) : null;
            parent::__construct(
                'mysql:host='.$this->host.';'.
                'port='.$this->port.';'.
                'dbname='.$this->base,
                $this->user,
                $this->pass,
                $options
            );
        } catch(Exception $e) {
            echo 'Erreur : '.$e->getMessage().'<br />';
            echo 'N° : '.$e->getCode();
        }
    }

    public function __construct(
        $host='localhost', $base='database', $user='user', $pass='', $port=3306, $charset='utf8'
    )
    {
        $this->host    = $host;
        $this->base    = $base;
        $this->user    = $user;
        $this->pass    = $pass;
        $this->port    = $port;
        $this->charset = $charset;

        $this->connect();
    }

    public function executeQuery($query, $data = [])
    {
        $stmt = parent::prepare($query);

        try {
            $stmt->execute($data);
            return $stmt;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insert($query, $data = [])
    {
        return $this->executeQuery($query, $data) ? ( parent::lastInsertId() ? parent::lastInsertId() : true ) : false;
    }

    public function select($query, $data = [])
    {
        return $this->executeQuery($query, $data);
    }

    public function update($query, $data = [])
    {
        return $this->executeQuery($query, $data);
    }

    public function delete($query, $data = [])
    {
        return $this->executeQuery($query, $data);
    }

    public function first($query, $data = [])
    {
        $result = $this->select($query, $data);
        return $result->fetchObject();
    }

    public function get($query, $data = [], $type = PDO::FETCH_OBJ)
    {
        $results = $this->select($query, $data);
        return $results->fetchAll($type);
    }

}
