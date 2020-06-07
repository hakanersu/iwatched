<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class CrewImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.crew.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing crew.</info>');

        DB::statement("COPY crews(tconst, directors, writers) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        DB::table('crews')->where('id', 1)->delete();
        DB::raw(DB::statement('CREATE INDEX ON public.crews (tconst)'));    
        return $this;
    }
}
