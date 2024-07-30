<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*route for auth login & register*/

Route::prefix('auth')->group(function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/register", [AuthController::class, 'register']);
    Route::get("/logout", [AuthController::class, 'logout']);
});

Route::prefix("posts")->group(function () {
    Route::get("/", [PostsController::class, 'get']);
    Route::get("/{id}", [PostsController::class, 'getById']);
});

Route::middleware('auth:sanctum')->group(function () {
    # route posts with auth
    Route::prefix('posts')->group(function () {
        Route::post("/", [PostsController::class, 'store']);
        Route::patch("/{id}", [PostsController::class, 'update']);
        Route::delete("/{id}", [PostsController::class, 'delete']);
    });
    Route::get("/users", [UserController::class, 'get']);
    # she profile users
    Route::prefix('profile')->group(function () {
        Route::get("/", [UserController::class, 'profile']);
        Route::post("/address", [AddressController::class, 'create']);
    });
});
