<?php


namespace App\Watched\Traits;


use App\Jobs\FetchPosterJob;
use App\Models\Title;

trait TitleFilter
{
    public function filter()
    {
        $movies = Title::query();

        if (request()->has('rating') && request('rating') !== 'Rating') {
            $movies = $movies->wherehas('rating', function ($q) {
                return $q->where([
                    ['average_rating', '>=', (int) request('rating')],
                    ['average_rating', '<', (int)(request('rating')+1)]
                ]);
            });
        }

        $movies = $movies->with(['poster', 'rating', 'watched'])
            ->orderByDesc('weight');

         if (request('not_watched') === 'yes') {
             $movies = $movies->whereDoesntHave('watched');
         }

        if (request()->has('selected_year') && request('selected_year')!== null) {
            $movies = $movies->where('start_year', request('selected_year'));
        }

        return $movies;
    }

    private function checkPoster($movie)
    {
        if (is_null($movie->poster->id) && config('iwatched.save_posters')) {
            dispatch(new FetchPosterJob($movie->tconst));
        }
    }

}
