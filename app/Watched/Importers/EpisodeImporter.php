<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class EpisodeImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.episode.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing episode.</info>');

        DB::statement("COPY episodes(tconst,parent_tconst,season_number,episode_number) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        DB::table('episodes')->where('id', 1)->delete();
        DB::raw(DB::statement('CREATE INDEX ON public.episodes (tconst)'));
        DB::raw(DB::statement('CREATE INDEX ON public.episodes (parent_tconst)'));
        return $this;
    }
}
