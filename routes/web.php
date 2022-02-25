<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
auth()->loginUsingId(1);

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->resource('/movies', MovieController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('/series', SeriesController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/search', [SearchController::class, 'search']);
Route::middleware(['auth:sanctum', 'verified'])->put('/token', [TokenController::class, 'update'])->name('token');

Route::middleware(['auth:sanctum', 'verified'])->post('/watch', \App\Http\Controllers\WatchController::class);
Route::middleware(['auth:sanctum', 'verified'])->post('/check-poster', [PosterController::class, 'check']);
