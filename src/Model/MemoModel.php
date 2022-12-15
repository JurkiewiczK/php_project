<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\AbstractModel;
use App\Exception\AppException;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class MemoModel extends AbstractModel implements ModelInterface
{

    public function list($search, string $sortby, string $sortorder): array
    {

        try {

            if (!in_array($sortby, ['created', 'title'])) {
                $sortby = 'title';
            }

            if (!in_array($sortorder, ['asc', 'desc'])) {
                $sortorder = 'asc';
            }


            $query = "SELECT id, title, created FROM notes ORDER BY $sortby $sortorder";
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych.", 400, $e);
        }
    }


    public function search(string $search, string $sortby, string $sortorder): array
    {
        try {

            if (!in_array($sortby, ['created', 'title'])) {
                $sortby = 'title';
            }

            if (!in_array($sortorder, ['asc', 'desc'])) {
                $sortorder = 'asc';
            }

            $search = $this->conn->quote('%' . $search . '%', PDO::PARAM_STR);
            $query = "SELECT id, title, created FROM notes WHERE title LIKE ($search) ORDER BY $sortby $sortorder";
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych.", 400, $e);
        }
    }


    public function get(int $id): array
    {

        try {
            $sql_query = "SELECT * FROM notes WHERE id  = $id";
            $result = $this->conn->query($sql_query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException(" Nie udało się pobrać notatki.", 400, $e);
        }

        if (!$note) {
            throw new NotFoundException("Nie ma takiej notatki w bazie.");
        }

        return $note;
    }


    public function create($data): void
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


    public function edit(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query =
                "UPDATE notes 
            SET title = $title, 
            description = $description 
            WHERE id = $id";
        } catch (Throwable $e) {
            throw new StorageException('Update issue');
        }

        $this->conn->exec($query);
    }

    public function delete($id): void
    {
        try {
            $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new AppException('Deleting error' . $e->getMessage(), 400, $e);
        }
    }
}
