<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Name;
use App\Title;
use App\Watched\Traits\TitleFilter;

class MovieController extends Controller
{
    use TitleFilter;

    public function index()
    {
        $movies = $this->filter()->simplePaginate(10);

        $movies->each(function ($movie) {
            $this->checkPoster($movie);
        });

        return view('movies', compact('movies'));
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
