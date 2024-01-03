<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoConvertedNotification extends Notification implements ShouldQueue
{
    protected $video;

    public function __construct($video)
    {
        $this->video = $video;
    }

    public function via($notifiable)
    {
        return ['database']; // Andere Optionen: 'mail', 'database', 'broadcast', etc.
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Dein Video wurde erfolgreich konvertiert.' // Hier deine Flash-Nachricht
        ];
    }
}
