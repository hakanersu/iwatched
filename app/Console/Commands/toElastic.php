<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class toElastic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:elastic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import titles to elasticsearch.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command = base_path('bin') . '/abc import --src_type=postgres --src_filter=titles --src_uri="'.$this->postgresUrl().'" "http://iwatched-es01:9200/titles" 2>/dev/null';
        $this->info($command);
        exec($command, $output, $return);
        if (!$return) {
            $this->info("Import succesfull");
        }else {
            $this->error("ES cluster not up yet please take a few minutes and try again.");
        }
    }

    private function postgresUrl(): string
    {
        return "postgresql://".env('DB_USERNAME').":".env('DB_PASSWORD')."@".env('DB_HOST').":".env('DB_PORT')."/".env('DB_DATABASE');
    }
}
