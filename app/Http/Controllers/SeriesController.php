<?php

namespace App\Http\Controllers;

use App\Watched\Traits\TitleFilter;
use Illuminate\Http\Request;
use App\Movie;
use App\Name;
use App\Title;
use App\Episode;

class SeriesController extends Controller
{
    use TitleFilter;

    public function index()
    {
        $movies = $this->filter('tvSeries')->simplePaginate(10);

        $movies->each(function ($movie) {
            $this->checkPoster($movie);
        });

        return view('series.index', compact('movies'));
    }

    public function show($id)
    {
        $title = Title::with('crew', 'principal', 'principal.name','poster','watched', 'rating')
            ->where('tconst', $id)
            ->first();

        $directors = Name::whereIn('nconst',explode(',', $title->crew->directors))->get();
        $writers = Name::whereIn('nconst', explode(',', $title->crew->writers))->get();

        $episodes = Episode::distinct('titles.tconst')->select([
                'episodes.id',
                'episodes.season_number',
                'titles.tconst',
                'titles.original_title',
                'titles.runtime_minutes',
                'titles.primary_title',
                'watched.watched_at'
            ])
            ->leftJoin('titles', 'episodes.tconst', '=', 'titles.tconst')
            ->leftJoin('watched', 'watched.tconst', '=', 'episodes.tconst')
            ->where('parent_tconst', $id)
            ->orderBy('titles.tconst', 'DESC')
            ->get();

        $seasons = $episodes->groupBy('season_number')->sortKeys();

        $seasons = $seasons->map(function ($item) {
            return $item->sortBy('episode_number')->values();
        });

        return view('series.show', compact('title', 'directors', 'writers', 'episodes', 'seasons'));
    }
}
