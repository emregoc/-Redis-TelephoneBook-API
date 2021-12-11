<?php

use App\Http\Controllers\TelephoneBookController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', [UserController::class, 'login']); 
Route::post('/register', [UserController::class, 'register']);



Route::middleware('auth:api')->group(function(){
    Route::delete('/person-delete/{id}', [TelephoneBookController::class, 'personDelete']);
    Route::put('/person-update/{id}', [TelephoneBookController::class, 'personUpdate']);
    Route::post('/add-person', [TelephoneBookController::class, 'addPerson']);
    Route::post('/person-search', [TelephoneBookController::class, 'personSearch']); 
    Route::get('/person-filter', [TelephoneBookController::class, 'personFilter']); 
    Route::get('/data', [TelephoneBookController::class, 'index']);

    Route::get('/logout', [UserController::class, 'logout']); 
});