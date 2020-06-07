<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Name;
use App\Title;
use App\Episode;

class SeriesController extends Controller
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
            ->where('title_type', 'tvSeries')
            ->orderByDesc('weight');

        if (request('not_watched') === 'yes') {
            $movies = $movies->whereDoesntHave('watched');
        }

        if (request()->has('selected_year') && request('selected_year')!== '') {
            $movies = $movies->where('start_year', request('selected_year'));
        }

        $movies = $movies->simplePaginate(10);

        $year = request('year', \Carbon\Carbon::now()->year);

        return view('series.index', compact('movies','year'));
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
