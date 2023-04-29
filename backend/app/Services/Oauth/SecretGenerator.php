<?php declare(strict_types = 1);

namespace App\Services\Oauth;

use App\Models\User;
use Laravel\Passport\ClientRepository;

class SecretGenerator {
  public function generateClientIdAndSecret(
    int $userId,
    array $scope = ['*'],
    string $redirect = ''
  ): array {
    $userData = User::find($userId)->toArray();
    $redirect = empty($redirect) ? 'http://localhost/callback' : $redirect;
    $scope    = implode(',', $scope);

    $clientRepository = new ClientRepository;
    $client = $clientRepository->create($userData['id'], $userData['email'], $redirect, $scope);

    // Generate a client secret
    $client->makeVisible('secret');
    $clientSecret = $client->secret;
    $clientId = $client->id;

    $data = [
      'client_id' => $clientId,
      'client_secret' => $clientSecret
    ];

    return $data;
  }
}
