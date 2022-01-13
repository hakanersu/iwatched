<?php


namespace App\Watched\Importers;


use Illuminate\Support\Facades\DB;

class PrincipalImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.principals.tsv';

    public function start(): ImporterInterface
    {
        $now = now();
        $this->output->writeln('<info>Importing principals.</info>');

        DB::statement("COPY principals(tconst,ordering,nconst,category,job,characters) FROM '{$this->tsvPath}'");

        $this->output->writeln('<comment>Importing principals finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Principals indexing started.</info>');
        $now = now();

        DB::table('principals')->where('id', 1)->delete();

        $this->output->writeln('<comment>Principals index process finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }
}
