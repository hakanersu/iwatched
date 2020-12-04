<?php

namespace App\Models;

use App\Watched\Traits\Watchable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Name
 * @package App\Models
 * @mixin \Eloquent
 */
class Episode extends Model
{
    use Watchable;

    public function getIsWatchedAttribute()
    {
        return !! $this->watched_at;
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'parent_tconst', 'tconst');
    }
}
