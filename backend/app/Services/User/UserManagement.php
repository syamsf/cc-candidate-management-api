<?php declare(strict_types = 1);

namespace App\Services\User;

use App\Models\UserRoles as ModelUserRoles;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;

class UserManagement {
  public function registerUser(array $userData): array {
    if (empty($userData))
      throw new \Exception("user_data is required");

    // Role validation
    ModelUserRoles::findOrFail($userData['role_id'])->toArray();

    $userData['password'] = bcrypt($userData['password']);
    $result = ModelsUser::create($userData)->toArray();

    unset($result['password']);

    return $result;
  }

  public function login(string $email, string $password): array {
    if (empty($email) || empty($password))
      throw new \Exception("email or password is required");

    $result = ModelsUser::where(['email' => $email])->with('roles')->first();
    if (empty($result))
      throw new \Exception("email is not registered yet");

    if (!Hash::check($password, $result->password)) {
      throw new \Exception("failed to authenticate with email {$email}");
    }

    $scope = explode(',', $result->roles->allowed_scope);

    $modelUser = ModelsUser::find($result['id']);
    $accessToken = $modelUser->createToken('Personal Access Token', $scope)->accessToken;

    return [
      'email'        => $email,
      'user_id'      => $result['id'],
      'scope'        => $scope,
      'access_token' => $accessToken
    ];
  }
}
