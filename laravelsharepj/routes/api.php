<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;

Route::apiResource('/users', UserController::class);
Route::apiResource('/posts', PostController::class);
Route::apiResource('/favorite', FavoriteController::class);
Route::apiResource('/posts/{postId}/comments', CommentController::class);