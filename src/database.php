<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageExceptions.php");
require_once("src/Exceptions/ConfigurationException.php");


use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use PDO;
use PDOException;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {

        try {

            $this->validate_db($config);
            $this->connection($config);
            dump($this->conn);  

        } catch (PDOException $e) {
            throw new StorageException('Connection failed ( database.php)');
        }
    }

    public function createNote(): void 
    {
        echo 'test notatki';
    }

    private function connection(array $config)
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO($dsn, $config['user'], $config['password']);
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
