<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BungaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('bunga', [BungaController::class, 'store'] );
Route::middleware('auth:sanctum')->delete('bunga/{bunga}', [BungaController::class, 'destroy'] );
Route::middleware('auth:sanctum')->patch('bunga/{bunga}', [BungaController::class,'update']);
Route::middleware('auth:sanctum')->get('contact', [ContactController::class, 'index'] );
Route::middleware('auth:sanctum')->delete('contact/{contact}', [ContactController::class, 'destroy'] );

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::post('contact', [ContactController::class, 'store'] );

Route::get('bunga', [BungaController::class, 'index'] );
Route::get('bunga/{bunga}', [BungaController::class, 'show'] );
Route::post('bunga/{bunga}', [BungaController::class,'update']);
