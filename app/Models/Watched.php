<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watched extends Model
{
    protected $table = 'watched';

    protected  $guarded = [];

    public function title()
    {
        return $this->belongsTo(Title::class, 'tconst', 'tconst');
    }

    public function url()
    {
        if ($this->title_type === 'movie') {
            return route('movies.show', [$this->tconst]);
        }

        return '/series/'.$this->tconst;
    }

    public function watchable()
    {
        return $this->morphTo();
    }
}
