<?php

namespace App\Console\Commands;

use App\Watched\Importers\ImporterInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Storage;
class ImportTitles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:titles
        {--skip= : Which tables to skip process. Comma separated.}
        {--only= : Only given tables will process. Comma separated. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import titles.';

    protected $fields = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting.');

        $fields = $original = ['title', 'episode', 'principal', 'name', 'crew', 'aka', 'rating'];

        Storage::makeDirectory('imdb');

        $skip = $this->option('skip');
        $only = $this->option('only');

        if ($skip) {
            $skip = explode(',', $skip);
            $fields = array_diff($fields, $skip);
        }

        if ($only) {
            $fields = array_intersect($fields, explode(',', $only));
        }

        $this->fields = collect($fields);

        if ($this->fields->count() <=0) {
            $this->info("Nothing to do, available fields: ". json_encode($original));
            return false;
        }

        $this->dropTables();
        $this->createTables();

        $this->fields->each(fn($field) => $this->importer($field)->download($this->output)->start()->index());
    }

    private function dropTables(): void
    {
        $this->fields->each(function ($field) {
            $table = Str::plural($field);
            Schema::dropIfExists($table);
            $migration = "create_{$table}_table";
            $this->info("Dropping {$table}.");
            DB::table('migrations')->where('migration', 'like', "%{$migration}")->delete();
        });

        $this->callSilent('migrate:rollback', ['--path' => 'database/migrations/imdb','--force' => true, '--quiet' => true]);
    }

    private function createTables(): void
    {
        $this->info('Migrating tables.');
        $this->callSilent('migrate', ['--path' => 'database/migrations/imdb', '--force' => true, '--quiet' => true]);
    }

    private function importer($field): ImporterInterface
    {
        $name =  "App\Watched\Importers\\". Str::studly("{$field}_importer");
        return new $name;
    }
}
