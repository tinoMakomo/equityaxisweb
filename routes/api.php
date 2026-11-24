<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\CategoryApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Posts
Route::get('/posts',              [PostApiController::class, 'index']);
Route::get('/posts/latest',       [PostApiController::class, 'latest']);
Route::get('/posts/search',       [PostApiController::class, 'search']);
Route::get('/posts/slug/{slug}',  [PostApiController::class, 'showBySlug']);
Route::get('/posts/tag/{tag}',    [PostApiController::class, 'byTag']);
Route::get('/posts/trending',     [PostApiController::class, 'trending']);
Route::get('/posts/top',          [PostApiController::class, 'top']);
Route::get('/posts/more',         [PostApiController::class, 'more']);
Route::get('/posts/{id}/related', [PostApiController::class, 'related']);
Route::get('/posts/{id}',         [PostApiController::class, 'show']);

// Categories
Route::get('/categories',             [CategoryApiController::class, 'index']);
Route::get('/categories/{id}',        [CategoryApiController::class, 'show']);
Route::get('/categories/{id}/posts',  [CategoryApiController::class, 'posts']);
