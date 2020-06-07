<?php


namespace App\Watched\Importers;


use Illuminate\Support\Facades\DB;

class PrincipalImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.principals.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing principals.</info>');

        DB::statement("COPY principals(tconst,ordering,nconst,category,job,characters) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        DB::table('principals')->where('id', 1)->delete();

        return $this;
    }
}
