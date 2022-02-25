<?php

namespace App\Repository;

use App\Models\Episode;
use App\Models\User;

class EpisodeRepository implements EpisodeInterface
{
    public User $user;

    public ?string $tconst;

    public ?string $season;

    public function __construct()
    {
        /** @var User $user */
        $user = auth()->user();
        $this->user = $user;
        $this->tconst =  request('tconst');
        $this->season = request('season');

        Episode::where('tconst', request('tconst'))->firstOrFail();
    }

    public function watch(): \Illuminate\Database\Eloquent\Model|Episode
    {
        return $this->user->watched()->firstOrcreate([
            'title_type' => Episode::class,
            'tconst_id' => $this->tconst,
            'user_id' => $this->user->id,
        ],[
            'watched_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function unWatch()
    {
        return $this->user->watched()->where('tconst_id', $this->tconst)->delete();
    }

    public function watchAll(): void
    {

    }


    public function unWatchAll(): void
    {

    }


}
