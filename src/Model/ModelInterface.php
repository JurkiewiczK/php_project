<?php

declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function list($search, string $sortby, string $sortorder): array;

    public function search(string $search, string $sortby, string $sortorder): array;

    public function get(int $id): array;

    public function create($data): void;

    public function edit(int $id, array $data): void;

    public function delete($id): void;
}
