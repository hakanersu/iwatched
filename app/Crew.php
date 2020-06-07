<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    public function name()
    {
        return $this->hasOne(Name::class, 'nconst', 'nconst');
    }
}
