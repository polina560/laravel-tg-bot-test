<?php

use App\Http\Controllers\Api\TextController;
use App\OpenApi\Controllers\SwaggerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum', 'verified');

// middleware verified используется для проверки, что пользователь подтвердил свою электронную почту.

require __DIR__.'/auth.php';

Route::get('/openapi.json', [SwaggerController::class, 'json']);

Route::get('/texts', [TextController::class, 'index']);
