<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Watched extends Model
{
    use QueryCacheable;

    protected $table = 'watched';

    protected  $guarded = [];

    public function title()
    {
        return $this->hasOne(Title::class, 'tconst', 'tconst');
    }

    public function url()
    {
        if ($this->title_type === 'movie') {
            return route('movies.show', [$this->tconst]);
        }

        return '/series/'.$this->tconst;
    }
}
