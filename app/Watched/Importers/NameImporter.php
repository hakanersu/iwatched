<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class NameImporter extends Importer implements ImporterInterface
{
    protected $name = 'name.basics.tsv';

    public function start(): ImporterInterface
    {
        $now = now();
        $this->output->writeln('<info>Importing names.</info>');

        DB::statement("COPY names(nconst, primary_name, birth_year, death_year ,primary_profession,known_for_titles) FROM '{$this->tsvPath}'");

        $this->output->writeln('<comment>Importing names finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Names indexing started.</info>');
        $now = now();

        DB::table('names')->where('id', 1)->delete();

        $this->output->writeln('<comment>Names index process finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }
}
