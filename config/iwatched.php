<?php

return [
    'save_poster' => ENV('SAVE_POSTERS', false),
    'tmdb' => [
        'account_id' => env('TMDB_ACCOUNT_ID'),
        'v3' => env('TMDB_V3_KEY'),
        'v4' => env('TMDB_V4_KEY'),
        'elasticsearch' => env('ELASTICSEARCH', true)
    ]
];
