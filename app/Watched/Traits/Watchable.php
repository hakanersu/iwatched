<?php


namespace App\Watched\Traits;


use App\Models\Watched;

trait Watchable
{
    /**
     * Boot watchable trait.
     */
    protected static function bootWatchable()
    {
        static::deleting(function ($model) {
            $model->watched->each->delete();
        });
    }

    /**
     * Title, Episode or series can be watched.
     *
     * @return mixed
     */
    public function watched()
    {
        return $this->morphMany(Watched::class, 'tconst', 'title_type', null, 'tconst');
    }

    /**
     * Watch current model.
     *
     * @return mixed
     */
    public function watch()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->watched()->where($attributes)->exists()) {
            return $this->watched()->create($attributes);
        }
    }

    /**
     * Unwatch current model.
     */
    public function unwatch(): void
    {
        $attributes = ['user_id' => auth()->id()];

        $this->watched()->where($attributes)->get()->each->delete();
    }

    /**
     * Return watched state of model.
     *
     * @return bool
     */
    public function isWatched(): bool
    {
        return (bool)$this->watched->where('user_id', auth()->id())->count();
    }

    /**
     * Return watched status of model for user.
     *
     * @return bool
     */
    public function getIsWatchedAttribute(): bool
    {
        return $this->isWatched();
    }
}
