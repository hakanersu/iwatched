<?php

namespace App\Repository;

use App\Enum\WatchableEnum;

class WatchableFactory
{
    public static function process($type): EpisodeInterface
    {
        return match ($type) {
            WatchableEnum::EPISODE->value => new EpisodeRepository(),
            WatchableEnum::SERIES->value => new SeriesRepository(),
        };
    }

}
