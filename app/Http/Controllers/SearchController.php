<?php

namespace App\Http\Controllers;

use App\Watched;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        return response()->json([
            'results' => [],
        ]);

        if (!$query || $query === '') {
            return response()->json([
                'results' => [],
            ]);
        }

        $results = \DB::select(
            "SELECT
                primary_title,
                title_type,
                start_year,
                tconst
            FROM
                 titles,
                 plainto_tsquery('".$query."') AS q
            WHERE
                (tsv_title_text @@ q) and
                (title_type = 'movie' or title_type='tvSeries')
                ORDER BY weight DESC LIMIT 15;"
        );

        return response()->json($results);
    }

    public function regularSearch()
    {
        $name = request('search');

        if (strlen($name) < 3) {
            return response()->json(['titles' => []]);
        }

        $titles = Title::query();

        preg_match('/:year\s(\d{4})/m', $name, $output_array);

        if (count($output_array) > 0 && $output_array[1]) {
            $titles->where('start_year', $output_array[1]);
            $name = trim(str_replace($output_array[0], "", $name));
        }

        $titles = $titles->where('original_title', 'ILIKE', "%{$name}");

        $watched = cache()->remember("users_watched_" . auth()->id(), 60, function () {
            return Watched::where('title_type', '!=', 'tvEpisode')
                ->select('tconst')
                ->get()
                ->pluck('tconst')
                ->toArray();
        });

        $titles->orderBy('weight', 'DESC');

        $titles = $titles->take(10)->get();

        return response()->json([
            'titles' => $titles->map(function ($item) use ($watched) {
                $title = [
                    "original_title" => $item->original_title,
                    "start_year" => $item->start_year,
                    "weight" => $item->weight,
                    "primary_title" => $item->primary_title,
                    "title_type" => $item->title_type,
                    "tconst" => $item->tconst,
                    "watched" => false
                ];

                if (in_array($item->tconst, $watched)) {
                    $title['watched'] = true;
                }

                return $title;
            })
        ]);
    }

    public function searchInElasticsearch()
    {
        $name = request('search');

        $elasticQuery = view()->make("queries/elasticsearch", [])->render();

        $elasticQuery = json_decode($elasticQuery, true);

        preg_match('/:year\s(\d{4})/m', $name, $output_array);

        if (count($output_array) > 0 && $output_array[1]) {
            $search = trim(str_replace($output_array[0], "", $name));
            $elasticQuery['query']['bool']['must'][0]['multi_match']['query'] = strtolower($search);
            $elasticQuery['query']['bool']['must'][1]['match']['start_year'] = $output_array[1];
        } else {
            $elasticQuery['query']['bool']['must'][0]['multi_match']['query'] = strtolower($name);
        }

        $params = [
            'index' => 'titles',
            'body' => $elasticQuery,
        ];

        $client = ClientBuilder::create()->setHosts([env('SCOUT_ELASTIC_HOST')])->build();

        $results = $client->search($params);

        $watched = cache()->remember("users_watched_" . auth()->id(), 60, function () {
            return Watched::where('title_type', '!=', 'tvEpisode')
                ->select('tconst')
                ->get()
                ->pluck('tconst')
                ->toArray();
        });

        $hits = collect($results['hits']['hits']);

        return response()->json([
            'titles' => $hits->map(function ($item) use ($watched) {
                $item['_source']['watched'] = false;
                // its not a good way. Maybe i have to index watched model with laravel
                // scout and cross check in elastic search.
                if (in_array($item['_source']['tconst'], $watched)) {
                    $item['_source']['watched'] = true;
                }
                return $item['_source'];
            }),
        ]);
    }

    public function searchImdbId()
    {
        preg_match('/(tt(.*?)) :imdb/m', request('search'), $imdbOutput);

        if (count($imdbOutput) <= 0 || !isset($imdbOutput[1])) {
            return false;
        }

        $imdb = Title::where('tconst', $imdbOutput[1])->first();

        if (!$imdb) {
            return false;
        }

        $response = [
            'titles' => [
                [
                    "original_title" => $imdb->original_title,
                    "start_year" => $imdb->start_year,
                    "weight" => $imdb->weight,
                    "primary_title" => $imdb->primary_title,
                    "title_type" => $imdb->title_type,
                    "tconst" => $imdb->tconst
                ]
            ]
        ];

        return response()->json($response);
    }
}
