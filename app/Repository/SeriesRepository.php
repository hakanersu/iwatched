<?php

namespace App\Repository;

use App\Models\Episode;
use App\Models\Series;
use App\Models\User;

class SeriesRepository implements EpisodeInterface
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

        Series::where('tconst', request('tconst'))->firstOrFail();
    }
    public function watch(): \Illuminate\Database\Eloquent\Model|Series
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->watched()->firstOrCreate([
            'tconst_id' => $this->tconst,
            'title_type' => Series::class,
            'user_id' => auth()->id(),
        ],
            [
                'watched_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }

    public function unwatch(): mixed
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->watched()->where('tconst_id', $this->tconst)
            ->where('title_type', Series::class)->delete();
    }

    public function watchAll(): void
    {
        $episodes = $this->getEpisodes();

        $this->user->watched()->whereIn('tconst_id', $episodes->all())->delete();

        $results = $episodes->map(function($episode) {
            return [
                'title_type' => Episode::class,
                'tconst_id' => $episode,
                'user_id' => auth()->id(),
                'watched_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->all();

        $this->user->watched()->insert($results);
    }

    public function unwatchAll(): void
    {
        $episodes = $this->getEpisodes()->all();

        $this->user->watched()->whereIn('tconst_id', $episodes)->delete();
    }

    private function getEpisodes(): \Illuminate\Support\Collection
    {
        return  Episode::with('watched')->select(['episodes.tconst'])
            ->when(request()?->has('season'), function ($query) {
                return $query->where('season_number', request('season'));
            })
            ->where('parent_tconst', $this->tconst)->get()->pluck('tconst');
    }
}
