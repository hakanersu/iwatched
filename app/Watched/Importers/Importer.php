<?php

namespace App\Watched\Importers;

use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\ProgressBar;
use function ByteUnits\bytes;

abstract class Importer
{
    protected $tsvPath;

    protected $gzPath;

    /**
     * The output interface implementation.
     *
     * @var \Illuminate\Console\OutputStyle
     */
    protected $output;

    public function __construct()
    {
        $this->tsvPath = storage_path("app/imdb/{$this->name}");
        $this->gzPath = $this->tsvPath.'gz';
    }

    public function download($output, $force = false): ImporterInterface
    {
        $this->output = $output;

        $exists = file_exists($this->tsvPath);

        if ($exists && !$force) {
            return $this;
        }

        $progressBar = new ProgressBar($output, 100);
        $progressBar->setFormat("%status%\n%current%/%max%  [%bar%] %percent:3s%%\n");
        $progressBar->setMessage('Gathering download information.', 'status');
        $progressBar->start();

        $client = new Client(['verify' => false, 'base_uri' => 'https://datasets.imdbws.com/']);

        $client->request('GET', "{$this->name}.gz", [
            'sink' => $this->gzPath,
            'progress' => function ($dl_total_size, $dl_size_so_far) use ($progressBar) {
                $total = bytes($dl_total_size)->format('MB');
                $sofar = bytes($dl_size_so_far)->format('MB');
                $percentage = $dl_total_size != '0.00' ? number_format($dl_size_so_far * 100 / $dl_total_size) : 0;
                $progressBar->setMessage("Downloading {$this->name}.gz:   {$sofar}/{$total} ({$percentage}%)", 'status');

                if ($percentage % 10 === 0) {
                    $progressBar->advance();
                }
                $progressBar->display();
            },
        ]);
        $progressBar->finish();

        $this->untar($this->gzPath, $this->tsvPath);

        unlink($this->gzPath);

        return $this;
    }

    public function untar($file, $name)
    {
        $buffer_size = 4096;
        $file = gzopen($file, 'rb');
        $out_file = fopen($name, 'wb');
        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }
        fclose($out_file);
        gzclose($file);
    }
}
