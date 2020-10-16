<?php

class Database
{
    private $database_config = [
        'username' => 'cs5910',
        'password' => 'P@ssw0rd',
        'database' => 'cs5910'
    ];

    /**
     * @var null
     */
    private static $pdo = null;

    /**
     * @return PDO
     */
    public function getConnection()
    {
        if (Database::$pdo === null) {
            $charset = 'utf8mb4';
            $dsn = "mysql:host={$this->database_config['host']};dbname={$this->database_config['database']};charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                $pdo = new PDO($dsn, $this->database_config['username'], $this->database_config['password'], $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return Database::$pdo;
    }
}