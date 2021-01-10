<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Name;
use App\Models\Series;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::filter()->simplePaginate(10);

        $series->each(function ($movie) {
            $this->checkPoster($movie);
        });

        return view('series.index', compact('series'));
    }

    public function show($id)
    {
        $series = Series::with('crew', 'principal', 'principal.name','poster','watched', 'rating')
            ->where('tconst', $id)
            ->first();
        if (!$series) {
            abort(404);
        }
        $directors = Name::whereIn('nconst',explode(',', $series->crew->directors ?? ''))->get();
        $writers = Name::whereIn('nconst', explode(',', $series->crew->writers ?? ''))->get();

        $episodes = Episode::with('watched')->distinct('titles.tconst')->select([
                'episodes.id',
                'episodes.season_number',
                'titles.tconst',
                'titles.original_title',
                'titles.runtime_minutes',
                'titles.primary_title'
            ])
            ->leftJoin('titles', 'episodes.tconst', '=', 'titles.tconst')
            ->where('parent_tconst', $id)
            ->whereNotNull('season_number')
            ->orderBy('titles.tconst', 'DESC')
            ->get();

        $seasons = $episodes->groupBy('season_number')->sortKeys();

        $seasons = $seasons->map(function ($item) {
            return $item->sortBy('episode_number')->values();
        });

        return view('series.show', compact('series', 'directors', 'writers', 'episodes', 'seasons'));
    }
}
