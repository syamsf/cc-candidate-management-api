<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void {
      // Passport scope
      Passport::tokensCan([
        'manage-candidate'    => 'Manager candidate data',
        'read-only-candidate' => 'View candidate data',
      ]);

      // Passport token expiration
      Passport::tokensExpireIn(now()->addDays(15));
      Passport::refreshTokensExpireIn(now()->addDays(30));
      Passport::personalAccessTokensExpireIn(now()->addMonths(6));

      // Passport keys
      $privateKey = env('PASSPORT_PRIVATE_KEY');
      $publicKey = env('PASSPORT_PUBLIC_KEY');
      Passport::loadKeysFrom($privateKey, $publicKey);
    }
}
