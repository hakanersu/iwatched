<?php

namespace App\Http\Controllers;

use App\Watched;

class DashboardController extends Controller
{
    public function index()
    {
        $watchedByYears = Watched::select('titles.start_year')
            ->selectRaw("COUNT('id')")
            ->leftJoin('titles', 'watched.tconst', '=', 'titles.tconst')
            ->groupBy('titles.start_year')
            ->orderByRaw("COUNT('id') DESC")
            ->limit(15)
            ->get();

        $watched = Watched::query()
            ->selectRaw("count(case when title_type = 'tvEpisode' then 1 end) as tvEpisode")
            ->selectRaw("count(case when title_type = 'movie' then 1 end) as movie")
            ->selectRaw("count(case when title_type = 'tvSeries' then 1 end) as tvSeries")
            ->first();

    	return view('dashboard', compact('watched', 'watchedByYears'));
    }
}
