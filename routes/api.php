<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAccessTokenValid;
use App\Http\Controllers\Auth\UserRegistryController;
use App\Http\Controllers\Auth\TokenAuthController;
use App\Http\Controllers\EventController;

Route::controller(TokenAuthController::class)->middleware(['expiry'])->group(function() {
    Route::post('/auth', 'authenticate');
    Route::post('/auth/{token}', 'authenticateWithRefreshToken');
    Route::delete('/auth', 'revokeAllTokens');
});

Route::controller(EventController::class)->middleware(['expiry'])->group(function() {
    Route::get('/event', 'index');    
    Route::get('/event/{uuid}', 'show');
    Route::post('/event', 'store');
    Route::patch('/event/{uuid}', 'editEvent');
    Route::delete('/event', 'delete');
});

Route::controller(UserRegistryController::class)->middleware(['expiry'])->group(function() {
    Route::post('/auth/register', 'authenticate');
});