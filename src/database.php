<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageExceptions.php");
require_once("src/Exceptions/ConfigurationException.php");
require_once("src/Exceptions/NotFoundException.php");


use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
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


    public function downloadNotes(): array
    {

        try {
            $query = "SELECT id, title, created FROM notes";
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych.", 400, $e);
        }
    }

    public function getSingleNote(int $id): array
    {

        try {
            $sql_query = "SELECT * FROM notes WHERE id  = $id";
            $result = $this->conn->query($sql_query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException(" Nie udało się pobrać notatki.", 400, $e);
        }

        if (!$note) {
            throw new NotFoundException("Nie ma takiej notatki w bazie. Id : $id");
        }

        return $note;
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