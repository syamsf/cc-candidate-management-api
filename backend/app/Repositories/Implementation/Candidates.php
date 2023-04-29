<?php declare(strict_types = 1);

namespace App\Repositories\Implementation;

use App\Repositories\Interface\Candidates as ICandidates;
use App\Models\Candidates as MCandidate;

class Candidates implements ICandidates {
  public function findById(string $uuid, bool $strictChecking = false): array {
    if (empty($uuid))
      throw new \Exception("uuid is required");

    $query = MCandidate::where('id', $uuid)->first();

    if ($strictChecking && !$query)
      throw new \Exception("failed to find candidates with id {$uuid}");

    if (!$query)
      return [];

    return $query->toArray();
  }

  public function findAll(): array {
    return MCandidate::all()->toArray();
  }

  public function insert(array $data): array|bool {
    if (empty($data))
      throw new \Exception("candidate data is required for create process");

    $this->validateRequiredData($data);

    return MCandidate::create($data)->toArray();
  }

  public function update(array $searchColumn, array $updatedData, bool $strictChecking = false): array|bool {
    // Filter unique value
    $uniqueSearchValue = $this->filterUniqueKeys($searchColumn);
    $uniqueUpdatedData = $this->filterUniqueKeys($updatedData);

    $result = MCandidate::where($uniqueSearchValue)->update($uniqueUpdatedData);

    if (!$result && $strictChecking) {
      $searchValueString = json_encode($uniqueSearchValue);
      throw new \Exception("failed to update candidate data with param {$searchValueString}");
    }

    if (!$result)
      return false;

    return true;
  }

  public function delete(array $searchColumn, bool $strictChecking = false): array|bool{
    if (empty($searchColumn))
      throw new \Exception("search_column is required for delete process");

    // Filter unique value
    $uniqueParam = $this->filterUniqueKeys($searchColumn);

    $result = MCandidate::where($uniqueParam)->delete();

    if (empty($result) && $strictChecking) {
      $deleteParam = json_encode($uniqueParam);
      throw new \Exception("failed to delete with param {$deleteParam}");
    }

    return empty($result) ? false : true;
  }

  private function validateRequiredData(array $data): void {
    $requiredField = [
      'name',
      'education',
      'birthdate',
      'applied_position',
      'top_five_skills',
      'email',
      'phone',
      'resume'
    ];

    $missingColumn = array_diff($requiredField, array_keys($data));
    if (count($missingColumn) > 0) {
      $missingColumnString = json_encode($missingColumn);
      throw new \Exception("this column {$missingColumnString} is required");
    }

    // Validate for empty field
    foreach ($requiredField as $item) {
      if (empty($data[$item]))
        throw new \Exception("field {$item} is required");
    }
  }

  private function filterUniqueKeys(array $searchColumn): array {
    $uniqueValue = array_values(array_unique(array_keys($searchColumn)));
    if (empty($uniqueValue))
      throw new \Exception("unique_value is required for delete process");

    $reformattedParam = [];
    foreach ($uniqueValue as $item) {
      if (empty($searchColumn[$item]))
        continue;

      $reformattedParam[$item] = $searchColumn[$item];
    }

    return $reformattedParam;
  }
}
