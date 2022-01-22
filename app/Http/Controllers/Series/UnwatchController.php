<?php

namespace App\Http\Controllers\Series;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;

class UnwatchController extends Controller
{
    public function title(Request $request)
    {
        $request->validate([
            'tconst' => ['required', 'exists:episodes,tconst'],
        ]);

        auth()->user()->watched()->where('tconst_id', $request->get('tconst'))->delete();

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

        return back()->withFlash('the post is saved!');;
    }
}
