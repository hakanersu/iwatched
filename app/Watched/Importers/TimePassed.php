<?php

namespace App\Watched\Importers;

use Carbon\CarbonInterval;

class TimePassed
{
    public static function took($started)
    {
        return CarbonInterval::seconds(now()->diffInSeconds($started))->cascade()->forHumans();
    }

}
