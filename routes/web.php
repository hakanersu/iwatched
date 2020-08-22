<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::auth();

Route::middleware('auth')->group(function () {
    Route::resource('/watched', 'WatchedController');
	Route::resource('/movies', 'MovieController');
	Route::resource('/series', 'SeriesController');
	Route::get('/dashboard', 'DashboardController@index')->name('home');
	Route::get('search', 'SearchController@search')->name('search');
	//Route::redirect('home', '/dashboard');
});


