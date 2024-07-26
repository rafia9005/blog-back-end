<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/register", [AuthController::class, 'register']);
});

Route::prefix("posts")->group(function () {
    Route::get("/", [PostsController::class, 'index']);
    Route::get("/{id}", [PostsController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    # route posts with auth
    Route::prefix('posts')->group(function () {
        Route::post("/", [PostsController::class, 'create']);
    });
});
