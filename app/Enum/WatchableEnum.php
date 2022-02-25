<?php

namespace App\Enum;

enum WatchableEnum: string
{
    case SERIES ='series';
    case EPISODE = 'episode';
    case MOVIES = 'movies';

    public static function toArray(): array {
        return array_map(static fn ($status) => $status->value, self::cases());
    }
}
