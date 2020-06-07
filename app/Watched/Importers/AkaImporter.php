<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class AkaImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.akas.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing akas.</info>');

        DB::statement("COPY akas(title_id, ordering,title,region,language,types,attributes,is_original_title) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        DB::table('akas')->where('id', 1)->delete();

        return $this;
    }
}
