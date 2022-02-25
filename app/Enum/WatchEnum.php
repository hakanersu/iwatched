<?php

namespace App\Enum;

enum WatchEnum: string
{
    case WATCH = 'watch';
    case UNWATCH ='unwatch';
    case WATCH_ALL = 'watch-all';
    case UNWATCH_ALL = 'unwatch-all';

    public static function toArray(): array {
        return array_map(static fn ($status) => $status->value, self::cases());
    }
}
