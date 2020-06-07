<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    public function name()
    {
        return $this->hasOne(Name::class, 'nconst', 'nconst');
    }
}
