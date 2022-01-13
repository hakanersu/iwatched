<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class CrewImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.crew.tsv';

    public function start(): ImporterInterface
    {
        $now = now();
        $this->output->writeln('<info>Importing crew.</info>');

        DB::statement("COPY crews(tconst, directors, writers) FROM '{$this->tsvPath}'");

        $this->output->writeln('<comment>Importing crew finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Crew indexing started.</info>');
        $now = now();

        DB::table('crews')->where('id', 1)->delete();
        DB::raw(DB::statement('CREATE INDEX ON public.crews (tconst)'));

        $this->output->writeln('<comment>Crew index process finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }
}
