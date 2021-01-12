<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Name;
use App\Models\Title;
use App\Watched\Traits\TitleFilter;

class MovieController extends Controller
{

    public function index()
    {
        $movies = Movie::filter()->simplePaginate(10);

        $movies->each(function ($movie) {
            $this->checkPoster($movie);
        });

        return view('movies.index', compact('movies'));
    }

    public function show($id)
    {
        $movie = Movie::with('crew', 'principal', 'principal.name','poster','watched', 'rating')
            ->where('tconst', $id)
            ->firstOrFail();

        $this->checkPoster($movie);

        $directors = Name::whereIn('nconst',explode(',', $movie->crew->directors))->get();
        $writers = Name::whereIn('nconst', explode(',', $movie->crew->writers))->get();

        return view('movies.show', compact('movie', 'directors', 'writers'));
    }
}
