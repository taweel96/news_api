<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('authors', \App\Http\Controllers\News\ListAuthorsController::class);
Route::get('categories', \App\Http\Controllers\News\ListCategoriesController::class);
Route::get('news-sources', \App\Http\Controllers\News\ListNewsSourcesController::class);

Route::post('register', \App\Http\Controllers\Auth\RegisterController::class);
Route::post('login', \App\Http\Controllers\Auth\LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('news', \App\Http\Controllers\News\ListNewsController::class);
    Route::put('user/preferences', \App\Http\Controllers\User\UpdateUserPreferencesController::class);
});
