<?php

namespace App\Http\Livewire;

use App\Title;
use Illuminate\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class Movies extends Component
{
    use WithPagination;

    public $year = 2000;

    public $selectedYear = null;

    public $notWatched = 'no';

    public $rating = null;

    public $type;

    public function mount($type = 'movie')
    {
        $this->type = $type;
        $this->year = \Carbon\Carbon::now()->year;
    }

    public function updatingSelectedYear(): void
    {
        $this->gotoPage(1);
    }

    public function render()
    {
        $movies = Title::query();

        if ($this->rating && $this->rating !== 'All') {
            $movies = $movies->wherehas('rating', function ($q) {
                return $q->where([
                    ['average_rating', '>', (int) $this->rating],
                    ['average_rating', '<', (int)($this->rating+1)]
                ]);
            });
        }

        $movies = $movies->with(['poster', 'rating', 'watched'])
            ->where('title_type', $this->type === 'movie' ? 'movie' : 'tvSeries')
            ->orderByDesc('weight');

        if ($this->notWatched === 'yes') {
            $movies = $movies->whereDoesntHave('watched');
        }

        if ($this->selectedYear && $this->selectedYear!== '') {
            $movies = $movies->where('start_year', $this->selectedYear);
        }

        $movies = $movies->simplePaginate(10);

        return view('livewire.movies', [
            'movies' => $movies,
        ]);
    }

    public function paginationView()
    {
        return 'livewire.paginate';
    }
}
