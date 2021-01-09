<?php

namespace App\Models;

use App\Watched\Scopes\FilterScope;
use App\Watched\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static filter()
 */
class Movie extends Title
{
    use Filterable;

    protected $table = 'titles';

    protected static function booted()
    {
        static::addGlobalScope('titleType', function (Builder $builder) {
            $builder->where('title_type', 'movie');
        });
    }

    /**
     * Return poster
     *
     * @return string
     */
    public function image(): string
    {
        if (config('iwatched.fetch_posters')) {
            return $this->tmdb($this->tconst, 'movie_results');
        }
        return url("/storage/posters/{$this->poster->image}");
    }
}
