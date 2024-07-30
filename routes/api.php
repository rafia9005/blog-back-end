<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*route for auth login & register*/

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
        Route::post("/", [PostsController::class, 'store']);
        Route::patch("/{id}", [PostsController::class, 'update']);
        Route::delete("/{id}", [PostsController::class, 'delete']);
    });

    # she profile users
    Route::get("/profile/me", function () {
        return auth()->user();
    });
});
