<?php

namespace App\Http\Controllers;

use App\Jobs\FetchPosterJob;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkPoster($movie)
    {
        if (is_null($movie->poster->id) && config('iwatched.save_posters')) {
            dispatch(new FetchPosterJob($movie->tconst));
        }
    }
}
