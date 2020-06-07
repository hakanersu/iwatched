<?php

namespace App\Watched\Importers;

use Illuminate\Console\OutputStyle;

interface ImporterInterface
{
    public function start();

    public function index(): ImporterInterface;

    public function download(OutputStyle $outputStyle): ImporterInterface;
}
