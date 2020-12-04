<?php

namespace App\Models;

use App\Watched\Traits\Watchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
            'image' => 'movie.jpg'
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
}
