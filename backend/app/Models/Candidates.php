<?php declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model {
  use HasFactory;
  use HasUuids;

  protected $table = 'candidates';

  protected $fillable = [
    'id',
    'name',
    'education',
    'birthdate',
    'applied_position',
    'top_five_skills',
    'email',
    'phone',
    'resume',
    'last_position',
    'experience'
  ];
}
