<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $guarded = [];

    public function title()
    {
        return $this->belongsTo(Title::class, 'tconst', 'title_id');
    }
}
