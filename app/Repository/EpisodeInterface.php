<?php

namespace App\Repository;

interface EpisodeInterface
{
    public function watch();
    public function unwatch();
    public function watchAll();
    public function unwatchAll();
}
