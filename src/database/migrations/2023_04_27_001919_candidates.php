<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  private string $table = 'candidates';
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create($this->table, function (Blueprint $table) {
      $table->uuid('id')->unique();
      $table->string('email')->unique();
      $table->string('name');
      $table->string('education');
      $table->date('birthdate');
      $table->string('experience')->nullable();
      $table->string('last_position')->nullable();
      $table->string('applied_position');
      $table->string('top_five_skills');
      $table->string('phone');
      $table->string('resume');
      $table->timestamps();

      $table->index('email');
      $table->index('name');
      $table->index(['email', 'name']);
      $table->index('applied_position');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::drop($this->table);
  }
};
