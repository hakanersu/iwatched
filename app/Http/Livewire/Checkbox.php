<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Checkbox extends Component
{
	public $episode;

	public $checked = false;

	public function mount($episode)
    {
        $this->episode = $episode;

        if ($episode->watched_at) {
        	$this->checked = true;
        }

        \Log::info(json_encode($this->checked));
    }

    public function render()
    {
        return view('livewire.checkbox');
    }
}
