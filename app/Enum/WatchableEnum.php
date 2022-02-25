<?php

namespace App\Enum;

enum WatchableEnum: string
{
    case TITLE = 'title';
    case SERIES ='series';
    case EPISODE = 'episode';

    public static function toArray(): array {
        return array_map(static fn ($status) => $status->value, self::cases());
    }
}
