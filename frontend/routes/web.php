<?php

use App\Http\Controllers\User;
use App\Http\Middleware\CheckLoggedIn;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () { return view('login'); });
Route::post('/login', [User::class, 'login'])->name('login');
Route::post('/logout', [User::class, 'logout'])->name('logout');
Route::get('/register', function () { return view('register'); });

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware([CheckLoggedIn::class]);

Route::group(['prefix' => 'candidate', 'middleware' => [CheckLoggedIn::class]], function () {
  Route::post('/', [User::class, 'create'])->name('create');
  Route::post('/update/{id}', [User::class, 'update'])->name('update');
});
