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
        'titles' => cache()->rememberForever('titles', function () {
            return number_format(\App\Models\Title::count());
        }),
        'movies' => cache()->rememberForever('movies', function () {
            return number_format(\App\Models\Title::where('title_type', 'movie')->count());
        }),
        'series' => cache()->rememberForever('series', function () {
            return number_format(\App\Models\Title::where('title_type', 'tvSeries')->count());
        }),
        'episodes' => cache()->rememberForever('episodes', function () {
            return number_format(\App\Models\Title::where('title_type', 'tvEpisode')->count());
        }),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
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
