<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Video;
use Livewire\Component;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Session;

class VideoComponent extends Component
{
    // Eigenschaften zur Verwaltung des Videos und der Bookmarks
    public $videoUrl;
    public $videoTitle;
    public $bookmarked = false;
    public $errorMessage = '';

    // Livewire-Listener zum Ändern der aktuellen URL
    protected $listeners = ['currentUrlChanged'];

    // Aktualisiert die aktuelle URL
    public function currentUrlChanged($url)
    {
        $this->videoUrl = $url;
    }

    // Initialisierung der Komponente mit der Video-URL und ID
    public function mount($videoUrl, $videoId)
    {
        // Video-Details abrufen und zuweisen
        $video = Video::find($videoId);
        $this->videoUrl = $video->uid;
        $this->videoTitle = $video->title;
    }

    // Fügt ein Bookmark hinzu
    public function addToBookmarks()
    {
        // Video-Details aus der URL extrahieren
        $videoDetails = $this->getVideoDetailsFromUrl($this->videoUrl);
        $sessionId = Session::getId();

        // Überprüfen, ob das Video bereits als Bookmark für den aktuellen Benutzer existiert
        $existingBookmark = Bookmark::where('video_uid', $videoDetails['url'])
                                    ->where('session_id', $sessionId)
                                    ->first();

        if (!$existingBookmark) {
            // Wenn das Bookmark für den Benutzer nicht existiert, füge es hinzu
            $expirationTime = Carbon::now()->addHours(24);
            $sessionId = Session::getId();

            $video = Video::where('uid', $videoDetails['title'])->first();
            $baseURL = 'http://aerofun-dev.test/';
            $uniqueID = $video->uid;
            $videoURL = $baseURL . 'watch/' . $uniqueID;

            $bookmark = Bookmark::create([
                'name' => $video->title,
                'link' => $videoURL,
                'video_uid' => $videoDetails['url'],
                'session_id' => $sessionId,
                'expiration_time' => $expirationTime->toDateTimeString(),
            ]);

            if ($bookmark) {
                $this->bookmarked = true;
            }
        } else {
            // Wenn das Bookmark bereits für den Benutzer existiert, setze die entsprechende Nachricht
            $this->bookmarked = false;
            $this->errorMessage = 'Dieses Video befindet sich bereits in deinen Lesezeichen.';
        }
    }

    // Extrahiert Titel und URL aus der Video-URL
    public function getVideoDetailsFromUrl($videoUrl)
    {
        $baseUrl = 'http://aerofun-dev.test/watch/';
        $videoTitle = str_replace($baseUrl, '', $videoUrl);

        return [
            'title' => $videoTitle,
            'url' => $videoUrl,
        ];
    }

    // Rendert die Komponente
    public function render()
    {
        return view('livewire.video-component');
    }
}
