<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'db';
        $port = getenv('DB_PORT') ?: '5432';
        $dbname = getenv('DB_NAME') ?: 'matcha';
        $user = getenv('DB_USER') ?: 'matcha_user';
        $pass = getenv('DB_PASSWORD') ?: 'matcha_pass';

        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

        try
        {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die("Erro de ligação à base de dados: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new Database();
        }

        return self::$instance->pdo;
    }
}
