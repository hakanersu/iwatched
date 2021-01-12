<?php


namespace App\Watched\Traits;


trait Filterable
{
    public function scopeFilter($query)
    {
        if (request()->has('rating') && request('rating') !== 'Rating') {
            $query->wherehas('rating', function ($q) {
                return $q->where([
                    ['average_rating', '>=', (int) request('rating')],
                    ['average_rating', '<', (int)(request('rating')+1)]
                ]);
            });
        }

        $query->with(['poster', 'rating', 'watched'])->orderByDesc('weight')->orderByDesc('tconst');

        if (request('not_watched') === 'yes') {
            $query->whereDoesntHave('watched');
        }

        if (request()->has('selected_year') && (request('selected_year') !== null)) {
            $query->where('start_year', request('selected_year'));
        }
    }
}
