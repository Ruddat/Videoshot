<?php

namespace App\Jobs;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class CreateThumbnailFromVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $video;
    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        //
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $destination = '/' . $this->video->uid . '/' . $this->video->uid . '.png';

        FFMpeg::fromDisk('videos-temp')
        ->open($this->video->path)
        ->getFrameFromSeconds(4)
        ->export()
        ->toDisk('videos')
        ->save($destination);
        //->save($this->video->uid.'.png');

        $this->video->update([
            'thumbnail_image' => $destination
        ]);
    }
}
