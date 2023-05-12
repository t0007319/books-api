<?php

use App\Http\Controllers\Api\v1\BookController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// login - public route
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1', 'cors'], static function () {
    // Read Books public or private
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{id}', [BookController::class, 'show']);

    Route::middleware('auth:sanctum')->group(static function () {
        Route::get('/user', static function (Request $request) {
            return $request->user();
        });

        /** Allow Logged-in users to update and delete */
        // Create Book
        Route::post('books', [BookController::class, 'create']);

        // Update Book
        Route::put('books/{id}', [BookController::class, 'update']);

        // Delete Book
        Route::delete('books/{id}', [BookController::class, 'destroy']);
    });
});
