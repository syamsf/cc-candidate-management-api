<?php

namespace Database\Seeders;

use App\Models\UserRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder {
  private array $scope = [
    'candidate' => [
      'manage' => 'manage-candidate',
      'read'   => 'read-only-candidate'
    ]
  ];

  public function run(): void {
    $data = [
      [
        'id'   => 1,
        'name' => 'HRD Manager',
        'allowed_scope' => implode(',', [
          $this->scope['candidate']['manage'],
          $this->scope['candidate']['read']
        ])
      ],
      [
        'id'   => 2,
        'name' => 'HRD',
        'allowed_scope' => implode(',', [
          $this->scope['candidate']['read']
        ])
      ]
    ];

    UserRoles::upsert($data, ['id'], ['name', 'allowed_scope']);
  }
}
