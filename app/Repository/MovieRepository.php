<?php

namespace App\Repository;

use App\Models\Episode;
use App\Models\Movie;
use App\Models\User;

class MovieRepository implements EpisodeInterface
{
    public User $user;

    public ?string $tconst;

    public function __construct()
    {
        /** @var User $user */
        $user = auth()->user();
        $this->user = $user;
        $this->tconst =  request('tconst');

        Movie::where('tconst', request('tconst'))->firstOrFail();
    }
    public function watch()
    {
        /** @var User $user */
        $user = auth()->user();

        $user->watched()->firstOrCreate(
            [
                'tconst_id' => $this->tconst,
                'title_type' => Movie::class,
                'user_id' => auth()->id(),
            ],
            [
                'watched_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function unwatch()
    {
        /** @var User $user */
        $user = auth()->user();

        $user->watched()->where('tconst_id', $this->tconst)
            ->where('title_type', Movie::class)->delete();
    }
}
