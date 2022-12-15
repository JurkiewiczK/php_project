<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;

abstract class AbstractModel
{
    protected PDO $conn;

    public function __construct(array $config)
    {

        try {

            $this->validate_db($config);
            $this->connection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection failed ( database.php)');
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
