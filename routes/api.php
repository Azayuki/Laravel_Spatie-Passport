<?php

use Illuminate\Support\Facades\Route;

// to create a Route for our API
// Route::method('uri',[Controller, 'function_name'])
Route::post("login", [App\Http\Controllers\AuthController::class, "login"]);

// middleware is like a country wall border that blocks anyone that is not logged in or registered(like the code below)
Route::middleware(['auth:api'])->group(function () {

    // User Routes
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->middleware('can:index-user');
    Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show'])->middleware('can:view-user');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:create-user');
    Route::patch('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:update-user');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:delete-user');

    // Item Routes
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'index'])->middleware('can:index-items');
    Route::get('/items/{id}', [App\Http\Controllers\ItemController::class, 'show'])->middleware('can:view-item');
    Route::post('/items', [App\Http\Controllers\ItemController::class, 'store'])->middleware('can:create-item');
    Route::patch('/items/{id}', [App\Http\Controllers\ItemController::class, 'update'])->middleware('can:update-item');
    Route::delete('/items/{id}', [App\Http\Controllers\ItemController::class, 'destroy'])->middleware('can:delete-item');

    // check and revoke token
    Route::get('checkToken', [App\Http\Controllers\AuthController::class, "checkToken"]);
    Route::post('revokeToken',[App\Http\Controllers\AuthController::class, "revokeToken"]);
});

// there are two types of update request
// put() and patch()
// put() -> replaces an entire resource with a new representation provided in the request body
// patch() -> partial updates