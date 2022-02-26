<?php

namespace App\Models;

use App\Jobs\FetchPoster;
use App\Watched\Traits\Watchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Http;

/**
 * @property mixed title_type
 * @property mixed tconst
 * @property mixed is_watched
 * @property mixed poster
 */
class Title extends Model
{
    use Watchable;

    /**
     * Get poster of title.
     *
     * @return HasOne
     */
    public function poster(): HasOne
    {
        return $this->hasOne(Poster::class, 'title_id', 'tconst')->withDefault([
            'image' => 'movie.png',
        ]);
    }

    /**
     * Return poster
     *
     * @return string
     */
    public function image(): string
    {
        return url("/storage/posters/{$this->poster->image}");
    }

    /**
     * Get rating of title.
     *
     * @return HasOne
     */
    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class, 'tconst', 'tconst');
    }

    /**
     * Get crew of title.
     *
     * @return HasOne
     */
    public function crew(): HasOne
    {
        return $this->hasOne(Crew::class, 'tconst', 'tconst');
    }

    /**
     * Get principals of title.
     *
     * @return HasMany
     */
    public function principal(): HasMany
    {
        return $this->hasMany(Principal::class, 'tconst', 'tconst');
    }

    /**
     * Generate url of title
     *
     * @return string
     */
    public function url(): string
    {
        if ($this->title_type === 'movie') {
            return route('movies.show', [$this->tconst]);
        }

        return '/series/'.$this->tconst;
    }

    public static function tmdb($id, $type='movie_results'): string
    {
        $token = (auth()->check() && auth()->user()->token) ? auth()->user()->token : config("watched.tmdb_key");

        if (!$token) {
            return '/movie.png';
        }

        $response = Http::get("https://api.themoviedb.org/3/find/{$id}?api_key=".$token."&external_source=imdb_id");

        $posterPath = $response->json("{$type}.0.poster_path");

        $url = $posterPath ? "https://image.tmdb.org/t/p/w500{$posterPath}" : '/movie.png';

        if ($posterPath) {
            FetchPoster::dispatch($url, $id);
        }

//        if ($posterPath && auth()->guest()) {
//            FetchPoster::dispatch($url, $id);
//        } elseif ($posterPath && auth()->check() && auth()->user()->save_posters) {
//            FetchPoster::dispatch($url, $id);
//        }


        return $url;
    }

    public function watched(): HasOne
    {
        return $this->hasOne(Watched::class, 'tconst_id', 'tconst')
            ->where('user_id', auth()->id());
    }
}
