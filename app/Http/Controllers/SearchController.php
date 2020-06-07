<?php

namespace App\Http\Controllers;

use App\Title;
use App\Watched;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        $name = request('search');

        $m = view()->make("queries/elasticsearch", [])->render();

        $m = json_decode($m, true);

        preg_match('/:year\s(\d{4})/m', $name, $output_array);

        if (count($output_array)>0 && $output_array[1]) {
            $search = trim(str_replace($output_array[0], "", $name));
            $m['query']['bool']['must'][0]['multi_match']['query'] = strtolower($search);
            $m['query']['bool']['must'][1]['match']['start_year'] = $output_array[1];
        } else {
            $m['query']['bool']['must'][0]['multi_match']['query'] = strtolower($name);
        }

        preg_match('/(tt(.*?)) :imdb/m', $name, $imdb_ouput);


        if (count($imdb_ouput)>0 && $imdb_ouput[1]) {
            $search = trim(str_replace($imdb_ouput[1], "", $name));

            $imdb = Title::where('tconst', $imdb_ouput[1])->first();

            $response = [
                'titles' =>[
                    [
                        "original_title"=> $imdb->original_title,
                        "start_year"=> $imdb->start_year,
                        "weight"=> $imdb->weight,
                        "primary_title"=> $imdb->primary_title,
                        "title_type"=> $imdb->title_type,
                        "tconst"=> $imdb->tconst
                    ]
                ]
            ];

            if ($imdb) {
                return response()->json($response);
            }
        }

        $params = [
            'index' => 'titles',
            'body' => $m,
        ];

        $client = ClientBuilder::create()->setHosts([env('SCOUT_ELASTIC_HOST')])->build();

        $results = $client->search($params);

        $watched = Watched::where('title_type', '!=','tvEpisode')->select('tconst')->cacheFor(60*60)->cacheTags(['shelf:1'])->get()->pluck('tconst')->toArray();

        $hits = collect($results['hits']['hits']);

        return response()->json([
            'titles' => $hits->map(function ($item) use($watched) {
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
}
