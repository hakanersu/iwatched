<?php

namespace App\Jobs;

use App\Models\Poster;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchPosterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $titleID;

    /**
     * Create a new job instance.
     *
     * @param $titleID
     */
    public function __construct($titleID)
    {
        $this->titleID = $titleID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $info = "https://api.themoviedb.org/3/movie/{$this->titleID}?api_key=".config('movie.v3')."&language=en-US";
        $info = json_decode(file_get_contents($info));
        $file = file_get_contents("http://image.tmdb.org/t/p/w500{$info->poster_path}");
        $name = (string) Str::uuid().'.jpg';
        Storage::put("public/posters/".$name, $file);
        Poster::firstOrCreate(
            ['title_id' => $this->titleID],
            [
                'title_id' => $this->titleID,
                'image' => $name,
            ]
        );
    }
}
