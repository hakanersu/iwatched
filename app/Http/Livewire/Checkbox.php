<?php

namespace App\Http\Livewire;

use App\Models\Episode;
use Livewire\Component;

class Checkbox extends Component
{
    public $name;

    public $checked;

    public Episode $episode;

    public function mount($name, Episode $episode)
    {
        $this->name = $name;
        $this->episode = $episode;
        $this->checked = $episode->isWatched();
    }

    public function render()
    {
        return view('livewire.checkbox');
    }

    public function change()
    {
        if ($this->checked) {
            $this->checked = false;
            $this->episode->unwatch();
            return;
        }

        if ($this->episode->series && !$this->episode->series->isWatched()) {
            $this->episode->series->watch();
        }

        $this->checked = true;
        $this->episode->watch();
    }
}
