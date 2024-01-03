<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use FFMpeg\Coordinate\Dimension;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VideoProcessedNotification;

class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;
    protected $userId;

    public function __construct($video, $userId)
    {
        $this->video = $video;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        $destination = '/' . $this->video->uid . '/' . $this->video->uid . '.m3u8';

        // Verarbeitung der Videoformate
        $this->processVideoFormats($destination);

        // Aktualisierung der Videoattribute nach der Verarbeitung
        $this->updateVideoAttributes();

        // Löschen der temporären Videodateien
        $this->deleteTempVideo();

    //    $this->dispatchBrowserEvent('videoConverted');
    }

    private function processVideoFormats($destination): void
    {
        $this->exportVideoFormats($destination);
    }

    private function exportVideoFormats($destination): void
    {
        // Festlegen verschiedener Bitraten für das Video
        $lowBitrate = (new X264('aac', 'libx264'))->setKiloBitrate(500);
        $midBitrate = (new X264('aac', 'libx264'))->setKiloBitrate(1500);
        $superBitrate = (new X264('aac', 'libx264'))->setKiloBitrate(3000);

        // Export von HLS-Formaten für jedes Bitratenformat
        FFMpeg::fromDisk('videos-temp')
            ->open($this->video->path)
            ->exportForHLS()
            ->setSegmentLength(5)
            ->setKeyFrameInterval(48)
            ->addFormat($superBitrate)
            ->addFormat($lowBitrate)
            ->addFormat($midBitrate)
            ->onProgress(function ($progress) {
                // Aktualisierung des Verarbeitungsfortschritts des Videos
                $this->video->update([
                    'processing_percentage' => $progress
                ]);
            })
            ->toDisk('videos')
            ->inFormat($midBitrate)
            ->inFormat($superBitrate)
            ->save($destination);

        // Ermittlung der Dauer des Videos in Sekunden
        $video = FFMpeg::fromDisk('videos-temp')->open($this->video->path);
        $durationInSeconds = $video->getDurationInSeconds();
        $this->video->duration = $durationInSeconds;
    }

    private function updateVideoAttributes(): void
    {
        // Aktualisierung der Videoattribute nach der Verarbeitung
        $this->video->processed = true;
        $this->video->processed_file = $this->video->uid . '.m3u8';
        $this->video->save();

        // Benachrichtigung des Benutzers über die Verarbeitung des Videos
        $user = User::find($this->userId);
        if ($user) {
            $user->notify(new VideoProcessedNotification($this->video));
        } else {
            Log::error('User not found for sending notification.');
        }
    }

    private function deleteTempVideo(): void
    {
        // Löschen der temporären Videodateien
        Storage::disk('videos-temp')->delete($this->video->path);
        Log::info($this->video->path . ' video was deleted from videos-temp disk');
    }
}
