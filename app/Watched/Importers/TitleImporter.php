<?php

namespace App\Watched\Importers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TitleImporter extends Importer implements  ImporterInterface
{
    protected $name = 'title.basics.tsv';

    public function start(): ImporterInterface
    {
        $this->output->writeln('<info>Importing titles, may take some time</info>');

        DB::statement("COPY titles(tconst,title_type,primary_title,original_title,is_adult,start_year,end_year,runtime_minutes,genres) FROM '{$this->tsvPath}'");

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Title cleanup and indexing, may take some time</info>');

        $primary_title = DB::select(DB::raw('select id,primary_title,length(primary_title) from titles where length(primary_title) >= 255 order by length(primary_title) DESC'));
        foreach($primary_title as $title) {
            $description = Str::limit($title->primary_title, 200);
            DB::table('titles')->where('id', $title->id)->update([
                'primary_title' => $description,
            ]);
        }

        $original_title = DB::select(DB::raw('select id,original_title,length(original_title) from titles where length(original_title) >= 255 order by length(original_title) DESC'));

        foreach($original_title as $title) {
            $description = Str::limit($title->original_title, 200);
            DB::table('titles')->where('id', $title->id)->update([
                'original_title' => $description,
            ]);
        }

        DB::table('titles')->where('id', 1)->delete();

        Schema::table('titles', function (Blueprint $table) {
            $table->string('primary_title')->change();
            $table->string('original_title')->change();
        });

        $this->output->writeln('<info>Updating title columns.</info>');
        DB::raw(DB::statement('ALTER TABLE titles ALTER COLUMN start_year TYPE integer USING (start_year::integer)'));
        DB::raw(DB::statement('ALTER TABLE titles ALTER COLUMN end_year TYPE integer USING (end_year::integer)'));
        DB::raw(DB::statement('ALTER TABLE titles ALTER COLUMN runtime_minutes TYPE integer USING (runtime_minutes::integer)'));

        return $this;
    }
}
