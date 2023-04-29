<?php declare(strict_types = 1);

namespace App\Services\Candidates;

use App\Helpers\TimestampConverterTrait;
use App\Repositories\Interface\Candidates as ICandidates;

class CandidatesManagement {
  use TimestampConverterTrait;

  public function __construct(private ICandidates $iCandidates) {}

  public function create(array $data): array {
    // Reformat data that going to be created
    $data['top_five_skills'] = implode(',', $data['top_five_skills']);

    // Create action
    $result = $this->iCandidates->insert($data);

    // Reformat data
    $result['resume']          = url($result['resume']);
    $result['top_five_skills'] = explode(',', $result['top_five_skills']);
    $result['created_at']      = $this->toUtc($result['created_at']);
    $result['updated_at']      = $this->toUtc($result['updated_at']);

    return $result;
  }

  public function fetchAll(): array {
    $result = $this->iCandidates->findAll();

    $reformattedResult = [];
    if (!empty($result)) {
      foreach ($result as $item) {
        $item['resume']          = url($item['resume']);
        $item['top_five_skills'] = explode(',', $item['top_five_skills']);
        $item['created_at']      = $this->toUtc($item['created_at']);
        $item['updated_at']      = $this->toUtc($item['updated_at']);
        $reformattedResult[]     = $item;
      }
    }

    return $reformattedResult;
  }

  public function fetchById(string $uuid): array {
    $result = $this->iCandidates->findById($uuid, true);

    // Reformat data
    $result['resume']          = url($result['resume']);
    $result['top_five_skills'] = explode(',', $result['top_five_skills']);
    $result['created_at']      = $this->toUtc($result['created_at']);
    $result['updated_at']      = $this->toUtc($result['updated_at']);

    return $result;
  }

  public function delete(string $uuid): array {
    $searchColumn = ['id' => $uuid];
    $result = $this->iCandidates->delete($searchColumn);

    $message = "to delete candidate data with id {$uuid}";

    if (!$result)
      throw new \Exception("failed {$message}");

    return ["message" => "success {$message}"];
  }

  public function update(string $uuid, array $updatedData): array {
    if (empty($uuid) || empty($updatedData))
      throw new \Exception("uuid or updated_data is required");

    // Reformat updated data
    $isTopFiveSkillsShouldUpdated = isset($updatedData['top_five_skills']) && (count($updatedData['top_five_skills']) == 5);
    if ($isTopFiveSkillsShouldUpdated)
      $updatedData['top_five_skills'] = implode(',', $updatedData['top_five_skills']);

    $searchColumn = ['id' => $uuid];
    $result = $this->iCandidates->update($searchColumn, $updatedData);
    if (!$result)
      throw new \Exception("failed to update candidate data with id {$uuid}");

    return ["message" => "success to update candidate data with id {$uuid}"];
  }
}
