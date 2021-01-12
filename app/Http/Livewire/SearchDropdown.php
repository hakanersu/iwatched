<?php

namespace App\Http\Livewire;

use App\Models\Title;
use Livewire\Component;
use MeiliSearch\Endpoints\Indexes;

class SearchDropdown extends Component
{
    public $search;

    public $searchResults = [];

    public function updatedSearch($newValue)
    {
        if (strlen($this->search) < 3) {
            $this->searchResults = [];

            return;
        }

        $builder = $this->buildSearch();

        if ($builder->imdb) {
            $imdb = Title::where('tconst', $builder->imdb)->first();
            $this->searchResults = [$imdb];
            return;
        }

        $this->searchResults =  Title::search($builder->search, function (Indexes $meilisearch, $query, $options) use($builder){
            if ($builder->year) {
                $options['filters'] = 'start_year="'.$builder->year.'"';
            }

            if ($builder->type) {
                $type = $builder->type === 'series' ? 'tvSeries' : 'movie';
                $options['filters'] = isset($options['filters']) ? $options['filters'] . ' AND title_type="'.$type.'"' : 'title_type="'.$type.'"';
            }

            return $meilisearch->search($query, $options);
        })->get()->sortByDesc(function ($title) {
            return intval($title->weight);
        })->take(5);
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }

    private function buildSearch()
    {
        $year = false;
        $type = false;
        $search = $this->search;

        preg_match('/(tt(.*?)) :imdb/m', $this->search, $imdbOutput);

        if (count($imdbOutput) >0 || isset($imdbOutput[1])) {
            return (object) [
                'search' => $search,
                'year' => $year,
                'type' => $type,
                'imdb' => $imdbOutput[1]
            ];
        }

        preg_match('/:year\s(\d{4})/m', $this->search, $output_array);

        if (count($output_array)>0 && $output_array[1]) {
            $year = $output_array[1];
            $search = trim(str_replace($output_array[0], "", $search));
        }

        preg_match('/:type\s(series|movie)/m', $search, $new_output);

        if (count($new_output)>0 && $new_output[1]) {
            $type = $new_output[1];
            $search = trim(str_replace($new_output[0], "", $search));
        }

        return (object) [
            'search' => $search,
            'year' => $year,
            'type' => $type,
            'imdb' => false
        ];
    }
}
