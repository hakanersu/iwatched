<?php

namespace App\Jobs;

use App\Models\Poster;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchPoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $url, public string $titleId)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = file_get_contents($this->url);
        $name = (string) Str::uuid().'.jpg';
        Storage::put("public/posters/".$name, $file);
        Poster::firstOrCreate(
            ['title_id' => $this->titleId],
            [
                'title_id' => $this->titleId,
                'image' => $name,
            ]
        );
    }
}
