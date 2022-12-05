<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageExceptions.php");
require_once("src/Exceptions/ConfigurationException.php");


use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {

        try {

            $this->validate_db($config);
            $this->connection($config);

        } catch (PDOException $e) {
            throw new StorageException('Connection failed ( database.php)');
        }
    }

    public function createNote($data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));

            $sql_query = "INSERT INTO notes(title, description, created) VALUES($title, $description, $created)";
            
            $this->conn->exec($sql_query);
        } catch (Throwable $e) {
            throw new StorageException("Nie udalo się stworzyć notatki", 400);
        }
    }

    private function connection(array $config)
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO($dsn, $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    private function validate_db(array $data): void
    {
        if (
            empty($data['database'])
            || empty($data['host'])
            || empty($data['user'])
            || empty($data['password'])
        ) {
            throw new ConfigurationException('DB DATA FAIL');
        }
    }
}
