<?php

namespace App\Http\Livewire\Series;

use App\Models\Title;
use Livewire\Component;

/**
 * @property mixed series
 */
class Card extends Component
{
    public Title $series;

    public bool $isWatched;

    public function mount(Title $series): void
    {
        $this->series = $series;
        $this->isWatched = $series->is_watched;
    }
    public function render()
    {
        return view('livewire.series.card');
    }

    public function toggle(): bool
    {
        if ($this->series->is_watched) {
            $this->series->unwatch();
            $this->isWatched = false;
            return false;
        }
        $this->series->watch();
        $this->isWatched = true;
        return true;
    }
}
