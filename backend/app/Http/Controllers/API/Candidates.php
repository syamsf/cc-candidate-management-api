<?php declare(strict_types = 1);

namespace App\Http\Controllers\API;

use App\Request\Candidates\CreateValidation;
use App\Request\Candidates\UpdateValidation;
use App\Repositories\Implementation\Candidates as CandidatesRepo;
use App\Http\Controllers\Controller;
use App\Services\Candidates\CandidatesManagement;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ResponseFormatterTrait;
use App\Helpers\MysqlErrorHandlerTrait;
use Illuminate\Http\JsonResponse;

class Candidates extends Controller {
  use ResponseFormatterTrait, MysqlErrorHandlerTrait;

  public function create(CreateValidation $request): JsonResponse {
    try {
      $candidateData = [
        'name'             => $request->input('name'),
        'education'        => $request->input('education'),
        'birthdate'        => $request->input('birthdate'),
        'applied_position' => $request->input('applied_position'),
        'top_five_skills'  => $request->input('top_five_skills'),
        'email'            => $request->input('email'),
        'phone'            => $request->input('phone'),
        'experience'       => $request->input('experience'),
        'last_position'    => $request->input('last_position'),
        'resume'           => '',
      ];

      // Upload file handler
      // TODO: refactor to services
      $fileHandler     = $request->file('resume');
      $resumeExtension = $fileHandler->getClientOriginalExtension();
      $resumeFileName  = time() . " - {$candidateData['email']} - Resume" . "." . $resumeExtension;
      $resumePath      = $fileHandler->storeAs('resume', $resumeFileName, 'public');
      $resumeUrl       = Storage::url($resumePath);

      // Append candidate resume
      $candidateData['resume'] = $resumeUrl;

      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->create($candidateData);

      return $this->successResponse($result, 201);
    } catch (\Illuminate\Database\QueryException $e) {
      if (Storage::disk('public')->exists($resumePath)) {
        Storage::disk('public')->delete($resumePath);
      }

      $message = $this->handleMysqlError($e);
      return $this->errorResponse($message, 400);
    } catch (\Exception $e) {
      if (Storage::disk('public')->exists($resumePath)) {
        Storage::disk('public')->delete($resumePath);
      }

      return $this->errorResponse($e->getMessage());
    }
  }

  public function fetchAll(): JsonResponse {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->fetchAll();

      return $this->successResponse($result);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function fetchById(string $candidateId): JsonResponse {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->fetchById($candidateId);

      return $this->successResponse($result);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function delete(string $candidateId): JsonResponse {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->delete($candidateId);

      return $this->successResponse($result);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }

  public function update(UpdateValidation $request, string $candidateId): JsonResponse {
    try {
      $candidateData = [
        'name'             => $request->input('name'),
        'education'        => $request->input('education'),
        'birthdate'        => $request->input('birthdate'),
        'applied_position' => $request->input('applied_position'),
        'top_five_skills'  => $request->input('top_five_skills'),
        'email'            => $request->input('email'),
        'phone'            => $request->input('phone'),
        'experience'       => $request->input('experience'),
        'last_position'    => $request->input('last_position'),
      ];

      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->update($candidateId, $candidateData);

      return $this->successResponse($result);
    } catch (\Illuminate\Database\QueryException $e) {
      $message = $this->handleMysqlError($e);
      return $this->errorResponse($message, 400);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
