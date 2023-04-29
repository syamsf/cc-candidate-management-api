<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model {
  use HasFactory;

  protected $table = 'user_roles';

  protected $fillable = [
    'name',
    'allowed_scope'
  ];
}
