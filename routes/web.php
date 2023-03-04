<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExerciseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index']);

Route::prefix('exercise')->group(function () {
    Route::post(
        '/create',
        [ExerciseController::class, 'create']
    );
});

Route::get('/user', [UserController::class, 'index'])->name('user')->middleware('guest');
Route::post('/register', [UserController::class, 'registerAction']);
Route::post('/login', [UserController::class, 'loginAction']);
Route::get('/logout', [UserController::class, 'logoutAction'])->middleware('auth');

Route::get('/home', [UserController::class, 'home'])->name('home')->middleware('auth');
Route::post('/start-quiz', [UserController::class, 'startQuiz'])->name('start-quiz')->middleware('auth');
Route::post('/finish-quiz', [UserController::class, 'finishQuiz'])->name('finish-quiz')->middleware('auth');
