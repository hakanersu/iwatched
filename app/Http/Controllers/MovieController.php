<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Name;
use App\Title;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Title::query();

        if (request()->has('rating') && request('rating') !== 'All') {
            $movies = $movies->wherehas('rating', function ($q) {
                return $q->where([
                    ['average_rating', '>', (int) request('rating')],
                    ['average_rating', '<', (int)(request('rating')+1)]
                ]);
            });
        }

        $movies = $movies->with(['poster', 'rating', 'watched'])
            ->where('title_type', 'movie')
            ->orderByDesc('weight');

        if (request('not_watched') === 'yes') {
            $movies = $movies->whereDoesntHave('watched');
        }

        if (request()->has('selected_year') && request('selected_year')!== '') {
            $movies = $movies->where('start_year', request('selected_year'));
        }

        $movies = $movies->simplePaginate(10);

        $year = request('selected_year');

        return view('movies', compact('movies','year'));
    }

    public function show($id)
    {
        $title = Title::with('crew', 'principal', 'principal.name','poster','watched', 'rating')
            ->where('tconst', $id)
            ->first();

        $directors = Name::whereIn('nconst',explode(',', $title->crew->directors))->get();
        $writers = Name::whereIn('nconst', explode(',', $title->crew->writers))->get();

        return view('show', compact('title', 'directors', 'writers'));
    }
}
