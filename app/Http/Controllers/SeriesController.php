<?php

namespace App\Http\Controllers;

use App\Models\Name;
use Inertia\Inertia;
use App\Models\Series;
use App\Models\Episode;

class SeriesController extends Controller
{
    public function index(): \Inertia\Response
    {
        $series = Series::filter()->simplePaginate(8)->through(function ($show) {
            $show->poster->fetched = true;
            if ($show->poster->image === 'movie.png') {
                $show->poster->image = Series::tmdb($show->tconst, 'tv_results');
                $show->poster->fetched = false;
            }
            return $show;
        });;

        return Inertia::render('Movies/MovieIndex', [
            'movies' => $series,
            'type' => 'series'
        ]);
    }

    public function show($id): \Inertia\Response
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
                'episodes.episode_number',
                'titles.tconst',
                'titles.original_title',
                'titles.runtime_minutes',
                'titles.primary_title',
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
        return Inertia::render('Series/SeriesShow',  compact('series', 'directors', 'writers', 'episodes', 'seasons'));
    }
}
