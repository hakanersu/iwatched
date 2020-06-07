<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class NameImporter extends Importer implements ImporterInterface
{
    protected $name = 'name.basics.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing names.</info>');

        DB::statement("COPY names(nconst, primary_name, birth_year, death_year ,primary_profession,known_for_titles) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        DB::table('names')->where('id', 1)->delete();

        return $this;
    }
}
