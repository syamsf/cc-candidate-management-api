<?php declare(strict_types = 1);

namespace App\Http\Controllers\API;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Request\Candidates\CreateValidation;
use App\Request\Candidates\UpdateValidation;
use App\Repositories\Implementation\Candidates as CandidatesRepo;
use App\Http\Controllers\Controller;
use App\Services\Candidates\CandidatesManagement;
use Illuminate\Support\Facades\Storage;

class Candidates extends Controller {
  public function create(CreateValidation $request): array {
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

      // TODO: refactor response to custom http code
      return ['data' => $result];
    } catch (\Illuminate\Database\QueryException $e) {
      $errorCode = $e->errorInfo[1];

      $message = 'undefined error';
      if ($errorCode == 1062) {
        $message = "email already registered";
      }

      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $message]
      ], 400));
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    } finally {
      if (Storage::disk('public')->exists($resumePath)) {
        Storage::disk('public')->delete($resumePath);
      }
    }
  }

  public function fetchAll(): array {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->fetchAll();

      return ['data' => $result];
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }

  public function fetchById(string $candidateId): array {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->fetchById($candidateId);

      return ['data' => $result];
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }

  public function delete(string $candidateId): array {
    try {
      $candidateRepo       = new CandidatesRepo();
      $candidateManagement = new CandidatesManagement($candidateRepo);
      $result              = $candidateManagement->delete($candidateId);

      return ['data' => $result];
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }

  public function update(UpdateValidation $request, string $candidateId): array {
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

      return ['data' => $result];
    } catch (\Illuminate\Database\QueryException $e) {
      $errorCode = $e->errorInfo[1];

      $message = 'undefined error';
      if ($errorCode == 1062) {
        $message = "email already registered";
      }

      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $message]
      ], 400));
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }
}
