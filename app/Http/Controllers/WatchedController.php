<?php

namespace App\Http\Controllers;

use App\Watched;
use App\Title;
use Illuminate\Http\Request;

class WatchedController extends Controller
{
    public function index()
    {
        $items = Watched::with(['title', 'title.rating'])
            ->join('titles', 'watched.tconst', '=', 'titles.tconst')
            ->whereIn('titles.title_type', ['movie', 'tvSeries'])
            ->orderByDesc('titles.start_year')
            ->paginate(10);

        return view('watched', [
            'items' => $items
        ]);
    }

    public function update($id, Request $request)
    {
        $isWatched = $request->get('watched');

        if (!$isWatched) {
            $title = Title::where('tconst', $id)->firstOrFail();

            Watched::create([
                'tconst' => $title->tconst,
                'user_id' => auth()->id(),
                'title_type' => $title->title_type,
                'watched_at' => \Carbon\Carbon::now(),
            ]);
        } else {
            $watched = Watched::where('tconst', $id)->firstOrFail();
            $watched->delete();
        }
        cache()->forget("users_watched_".auth()->id());

        response()->noContent();
    }
}
