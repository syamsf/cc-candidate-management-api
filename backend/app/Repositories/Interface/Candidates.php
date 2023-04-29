<?php declare(strict_types = 1);

namespace App\Repositories\Interface;

interface Candidates {
  public function findById(string $uuid, bool $strictChecking = false): array;
  public function findAll(): array;
  public function insert(array $data): array|bool;
  public function update(array $searchColumn, array $updatedData, bool $strictChecking = false): array|bool;
  public function delete(array $searchColumn, bool $strictChecking = false): array|bool;
}
