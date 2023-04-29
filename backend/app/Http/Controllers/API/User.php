<?php declare(strict_types = 1);

namespace App\Http\Controllers\API;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Request\User\CreateValidation;
use App\Services\User\UserManagement;
use App\Request\User\LoginValidation;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatterTrait;
use App\Helpers\MysqlErrorHandlerTrait;
use App\Services\Oauth\SecretGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class User extends Controller {
  use ResponseFormatterTrait, MysqlErrorHandlerTrait;

  public function register(CreateValidation $request): JsonResponse {
    try {
      $userData = [
        'email'    => $request->input('email'),
        'name'     => $request->input('name'),
        'password' => $request->input('password'),
        'role_id'  => $request->integer('role_id', 1)
      ];

      $userManagement = new UserManagement();
      $result = $userManagement->registerUser($userData);

      return $this->successResponse($result);
    } catch (\Illuminate\Database\QueryException $e) {
      $message = $this->handleMysqlError($e);
      return $this->errorResponse($message);
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }

  public function login(LoginValidation $request): JsonResponse {
    try {
      $email    = $request->input('email');
      $password = $request->input('password');

      $userManagement = new UserManagement();
      $result = $userManagement->login($email, $password);

      return response()->json($result);
    } catch (\Exception $e) {
      throw new HttpResponseException(response()->json([
        'errors' => ['message' => $e->getMessage()]
      ], 400));
    }
  }

  public function generateClientIdAndSecret(Request $request): JsonResponse {
    try {
      $userId = auth()->user()->token()->user_id;

      $scope = $request->input('scope', ['*']);
      $redirect = $request->input('redirect', '');

      $secretGenerator = new SecretGenerator();
      $clientData = $secretGenerator->generateClientIdAndSecret($userId, $scope, $redirect);

      return $this->successResponse($clientData);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage());
    }
  }
}
