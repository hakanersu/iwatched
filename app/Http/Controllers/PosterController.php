<?php

namespace App\Http\Controllers;

use App\Models\Poster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PosterController extends Controller
{
    public function check(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'tconst' => ['required', 'min:2'],
        ]);

        $poster = Poster::where('title_id', $request->get('tconst'))->first();

        abort_unless((bool)$poster, 204);

        if (!Storage::exists('public/posters/' . $poster->image)) {
            $poster->delete();
        }

        return response()->noContent();
    }
}
