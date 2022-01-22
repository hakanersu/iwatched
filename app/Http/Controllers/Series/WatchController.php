<?php

namespace App\Http\Controllers\Series;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class WatchController extends Controller
{
    public function title(Request $request)
    {
        $request->validate([
            'tconst' => ['required', 'exists:episodes,tconst'],
        ]);

        auth()->user()->watched()->create([
            'title_type' => Episode::class,
            'tconst_id' => $request->get('tconst'),
            'user_id' => auth()->id(),
            'watched_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back();
    }

    public function all(Request $request)
    {
        $episodes = Episode::with('watched')->select(['episodes.tconst'])
            ->when($request->has('season'), function ($query) {
                return $query->where('season_number', request()->get('season'));
            })
            ->where('parent_tconst', $request->get('tconst'))->get()->pluck('tconst');

        auth()->user()->watched()->whereIn('tconst_id', $episodes->all())->delete();

        $results = $episodes->map(function($episode) {
            return [
                'title_type' => Episode::class,
                'tconst_id' => $episode,
                'user_id' => auth()->id(),
                'watched_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();

        auth()->user()->watched()->insert($results);

        return back();
    }
}
