<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BungaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::post('contact', [ContactController::class, 'store'] );
Route::get('contact', [ContactController::class, 'index'] );
Route::delete('contact/{contact}', [ContactController::class, 'destroy'] );

Route::post('bunga', [BungaController::class, 'store'] );
Route::get('bunga', [BungaController::class, 'index'] );
Route::delete('bunga/{bunga}', [BungaController::class, 'destroy'] );
Route::patch('bunga/{bunga}', [BungaController::class,'update']);
