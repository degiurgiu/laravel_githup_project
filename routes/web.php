<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubUserController;

Route::get('/', function () {
    return view('welcome');
});

//taylorotwell


Route::get('/', [GitHubUserController::class, 'index']);
Route::get('/search', [GitHubUserController::class, 'search']);
Route::get('/followers', [GitHubUserController::class, 'loadFollowers']);
