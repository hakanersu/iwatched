<?php

namespace App\Http\Controllers;

use App\Models\Watched;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $watchedByYears = Watched::select('titles.start_year')
            ->selectRaw("COUNT('id')")
            ->leftJoin('titles', 'watched.tconst_id', '=', 'titles.tconst')
            ->where('watched.title_type', 'App\Models\Movie')
            ->groupBy('titles.start_year')
            ->orderByRaw("COUNT('id') DESC")
            ->limit(15)
            ->get();

        $watched = Watched::query()
            ->selectRaw("count(case when title_type = 'App\Models\Episode' then 1 end) as tvEpisode")
            ->selectRaw("count(case when title_type = 'App\Models\Movie' then 1 end) as movie")
            ->selectRaw("count(case when title_type = 'tvSeries' then 1 end) as tvSeries")
            ->first();

        return Inertia::render('Dashboard', [
            'watched' => $watched,
            'watchedByYears' => $watchedByYears,
        ]);
    }
}
