<?php

namespace App\Console\Commands;


use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;


class VideoEncode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-encode:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Video Encoding';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $lowBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(500);
        $midBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(1000);
        $highBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(1500);

        FFMpeg::fromDisk('videos-temp')
            ->open('Big_Buck_Bunny_1080_10s_5MB.mp4')
            ->exportForHLS()
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)

            ->onProgress(function ($percentage) {
                $this->info("Progress: $percentage %");
            })

            ->toDisk('videos-temp')
            ->save('test/file.m3u8');

    }
}
