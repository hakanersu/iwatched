<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class EpisodeImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.episode.tsv';

    public function start(): ImporterInterface
    {
        $now = now();
        $this->output->writeln('<info>Importing episodes.</info>');

        DB::statement("COPY episodes(tconst,parent_tconst,season_number,episode_number) FROM '{$this->tsvPath}'");

        $this->output->writeln('<comment>Importing episodes finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Episodes indexing started.</info>');
        $now = now();

        DB::table('episodes')->where('id', 1)->delete();
        DB::raw(DB::statement('CREATE INDEX ON public.episodes (tconst)'));
        DB::raw(DB::statement('CREATE INDEX ON public.episodes (parent_tconst)'));

        $this->output->writeln('<comment>Episodes index process finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }
}
