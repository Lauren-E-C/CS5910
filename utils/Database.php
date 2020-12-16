<?php

class Database
{
    private $hostname = '192.168.0.18';
    #static private $hostname = '192.168.56.104';
    private $database = 'cs5910';
    private $username = 'cs5910';
    private $password = 'P@ssw0rd';

    /**
     * @var null
     */
    static private $pdo = null;

    /**
     * @return PDO
     */
    public function __construct()
    {
        if ($_SERVER['SERVER_ADDR'] === '185.201.11.125') {
            $this->hostname = 'localhost';
            $this->database = 'u684207109_cs5910';
            $this->username = 'u684207109_cs5910';
            $this->password = 'cs5910P@ssw0rd';
        }
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_EMULATE_PREPARES => true,
            ];
            try {
                self::$pdo = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$pdo;
    }

    public function errorCode()
    {
        return self::$pdo->errorCode();
    }

    public function errorInfo()
    {
        return self::$pdo->errorInfo();
    }

    public function prepare($sql, $options = false)
    {
        if (!$options) $options = array();
//        print_r($sql);echo "\n";
        return self::$pdo->prepare($sql, $options);
    }

    public function exec($statement)
    {
        return $statement->execute();
    }

    public function fetch($statement)
    {
        return $statement->fetch();
    }

    public function fetchAll($statement)
    {
        return $statement->fetchAll();
    }

    public function quote($input)
    {
        return self::$pdo->quote($input);
    }
}