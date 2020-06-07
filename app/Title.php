<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public function poster()
    {
        return $this->hasOne(Poster::class, 'title_id', 'tconst')->withDefault([
            'image' => 'movie.jpg'
        ]);
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'tconst', 'tconst');
    }

    public function watched()
    {
        return $this->hasOne(Watched::class, 'tconst', 'tconst');
    }

    public function crew()
    {
        return $this->hasOne(Crew::class, 'tconst', 'tconst');
    }

    public function principal()
    {
        return $this->hasMany(Principal::class, 'tconst', 'tconst');
    }

    public function getIsWatchedAttribute()
    {
        if (!$this->watched) {

        }
        return !!$this->watched;
    }

    public function url()
    {
        if ($this->title_type === 'movie') {
            return route('movies.show', [$this->idtconst]);
        }

        return '/series/'.$this->tconst;
    }
}
