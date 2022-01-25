<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function check(Request $request)
    {
        $request->validate([
            'tconst' => ['required', 'min:2'],
        ]);

        $poster = Poster::where('title_id', $request->get('tconst'))->first();

        abort_unless($poster, 404);

        if (!Storage::exists('public/posters/' . $poster->image)) {
            $poster->delete();
        }

        return response()->noContent();
    }
}
