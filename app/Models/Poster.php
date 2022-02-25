<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Name
 * @package App\Models
 * @mixin \Eloquent
 */
class Poster extends Model
{
    protected $guarded = [];

    public function title()
    {
        return $this->belongsTo(Title::class, 'tconst', 'title_id');
    }
}
