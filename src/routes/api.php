<?php

use App\Http\Controllers\API\Candidates;
use App\Http\Controllers\API\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Grouping based on v1
Route::group(['prefix' => 'v1', 'middleware' => ['json.response']], function () {
  Route::post('/login', [User::class, 'login']);
  Route::post('/register', [User::class, 'register']);

  Route::group(['prefix' => 'candidates'], function() {
    Route::post('/', [Candidates::class, 'create'])->middleware(['auth:api', 'scopes:manage-candidate,read-only-candidate']);
    Route::put('/{id}', [Candidates::class, 'update'])->middleware(['auth:api', 'scopes:manage-candidate,read-only-candidate']);
    Route::get('/', [Candidates::class, 'fetchAll'])->middleware(['auth:api', 'scopes:read-only-candidate']);
    Route::get('/{id}', [Candidates::class, 'fetchById'])->middleware(['auth:api', 'scopes:read-only-candidate']);
    Route::delete('/{id}', [Candidates::class, 'delete'])->middleware(['auth:api', 'scopes:manage-candidate,read-only-candidate']);
  });
});
