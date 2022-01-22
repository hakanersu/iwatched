<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeriesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->resource('/movies', MovieController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('/series', SeriesController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/search', [\App\Http\Controllers\SearchController::class, 'search']);
Route::middleware(['auth:sanctum', 'verified'])->put('/token', [\App\Http\Controllers\TokenController::class, 'update'])->name('token');

Route::middleware(['auth:sanctum', 'verified'])->post('/unwatch-all', [\App\Http\Controllers\Series\UnwatchController::class, 'all']);
Route::middleware(['auth:sanctum', 'verified'])->post('/watch-all', [\App\Http\Controllers\Series\WatchController::class, 'all']);
Route::middleware(['auth:sanctum', 'verified'])->post('/series/watch', [\App\Http\Controllers\Series\WatchController::class, 'title']);
Route::middleware(['auth:sanctum', 'verified'])->post('/series/unwatch', [\App\Http\Controllers\Series\UnwatchController::class, 'title']);
Route::middleware(['auth:sanctum', 'verified'])->post('/movies/watch', [MovieController::class, 'watch']);
Route::middleware(['auth:sanctum', 'verified'])->post('/movies/unwatch', [MovieController::class, 'unwatch']);
