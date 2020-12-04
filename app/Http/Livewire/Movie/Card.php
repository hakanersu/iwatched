<?php

namespace App\Http\Livewire\Movie;

use App\Models\Title;
use Livewire\Component;

class Card extends Component
{
    public Title $movie;

    public bool $isWatched;

    public function mount(Title $movie): void
    {
        $this->movie = $movie;
        $this->isWatched = $movie->is_watched;
    }

    public function render()
    {
        return view('livewire.movie.card');
    }

    public function toggle(): bool
    {
        if ($this->movie->is_watched) {
            $this->movie->unwatch();
            $this->isWatched = false;
            return false;
        }
        $this->movie->watch();
        $this->isWatched = true;
        return true;
    }
}
