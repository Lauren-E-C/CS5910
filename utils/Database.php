<?php

class Database
{
    static private $hostname = '192.168.0.18';
    static private $database = 'cs5910';
    static private $username = 'cs5910';
    static private $password = 'P@ssw0rd';

    /**
     * @var null
     */
    static private $pdo = null;

    /**
     * @return PDO
     */
    public function __construct()
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=".self::$hostname.";dbname=".self::$database.";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                self::$pdo = new PDO($dsn, self::$username, self::$password, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$pdo;
    }

    public function errorCode() {
        return self::$pdo->errorCode();
    }

    public function errorInfo() {
        return self::$pdo->errorInfo();
    }

    public function prepare($sql, $options = false) {
        if (!$options) $options = array();
        return self::$pdo->prepare($sql, $options);
    }

    public function exec($statement) {
        return $statement->execute();
    }

    public function fetch($statement) {
        return $statement->fetch();
    }

    public function fetchAll($statement) {
        return $statement->fetchAll();
    }

    public function quote ($input) {
        return self::$pdo->quote($input);
    }
}