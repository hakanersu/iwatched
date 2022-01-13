<?php

namespace App\Watched\Importers;

use Illuminate\Support\Facades\DB;

class RatingImporter extends Importer implements ImporterInterface
{
    protected $name = 'title.ratings.tsv';

    public function start(): ImporterInterface
    {
        $now = now();
        $this->output->writeln('<info>Importing ratings.</info>');

        DB::statement("COPY ratings(tconst,average_rating,num_votes) FROM '{$this->tsvPath}'");

        $this->output->writeln('<comment>Importing ratings finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }

    public function index(): ImporterInterface
    {
        $this->output->writeln('<info>Ratings indexing started.</info>');
        $now = now();

        DB::table('ratings')->where('id', 1)->delete();
        DB::raw(DB::statement('CREATE INDEX ON public.ratings (tconst)'));
        DB::raw(DB::statement('ALTER TABLE ratings ALTER COLUMN average_rating TYPE numeric(3,1) USING (average_rating::numeric(3,1))'));
        DB::raw(DB::statement('ALTER TABLE ratings ALTER COLUMN num_votes TYPE integer USING (num_votes::integer)'));

        $this->output->writeln('<comment>Rating indexing and column type casting finished in '.TimePassed::took($now).'.</comment>');
        $this->output->writeln('<info>Started to calculating and updating title weights.</info>');
        $now = now();

        DB::raw(DB::statement('UPDATE "titles" SET weight = ROUND(((ratings.num_votes*ratings.average_rating + (25000*7))/( ratings.num_votes+25000) )::numeric,2)*100 FROM "ratings" WHERE "titles"."tconst" = "ratings"."tconst"'));
        DB::raw(DB::statement('CREATE INDEX ON public.titles (weight)'));

        $this->output->writeln('<comment>Weight update and weight index finished in '.TimePassed::took($now).'.</comment>');

        return $this;
    }
}
