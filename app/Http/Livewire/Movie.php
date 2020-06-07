<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Movie extends Component
{
    public $movie;

    public $type;

    public $isWatched = false;

    public $route;

    public function mount($movie, $type ='movie')
    {
        $this->type = $movie->title_type === 'movie' ? 'movie' : 'series';
        $this->movie = $movie;
        $this->isWatched = $movie->is_watched;
        $this->route = $this->type === 'movie' ? 'movies' : 'series';
    }

    public function setWatched()
    {
        if ($this->movie->isWatched) {
            $this->movie->watched->delete();
            $this->isWatched = false;
        } else {
            $this->movie->watched()->create([
                'tconst' => $this->movie->tconst,
                'user_id' => auth()->id(),
                'title_type' => $this->movie->title_type,
                'watched_at' => \Carbon\Carbon::now()
            ]);
            $this->isWatched = true;
        }

    }

    public function render()
    {
        return view('livewire.movie');
    }
}
