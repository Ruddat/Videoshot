<?php

namespace App\Livewire\Video;

use App\Models\View;
use App\Models\Video;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WatchVideo extends Component
{
    public $video;

    protected $listeners = [
        'VideoViewed' => 'countView'
    ];

    public function mount(Video $video)
    {
        $this->video = $video;
    }

    public function render()
    {
        if (Auth::check()) {
            // Erfassen der angesehenen Videos
            $user = Auth::user();

            View::create([
                'user_id' => $user->id,
                'video_id' => $this->video->id,
            ]);
        }

        // Laden der nächsten Videos basierend auf dem aktuellen Video
        $nextVideos = Cache::remember('next_videos_' . $this->video->id, 3600, function () {
            return Video::where('id', '!=', $this->video->id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        return view('livewire.video.watch-video', compact('nextVideos'))
            ->extends('layouts.app');
    }

    #[On('countView')]
    public function countView()
    {
        // Hier wird das 'videoViewed'-Ereignis ausgelöst
        Log::info('countView() ausgeführt');
        //  $this->dispatch('videoViewed');
        // Videoansichten-Zähler um 1 erhöhen
        $this->video->update([
            'views' => $this->video->views + 1
        ]);
    }

    public function incrementViews()
    {
        // Hier wird das 'videoViewed'-Ereignis ausgelöst
        Log::info('countView() ausgeführt');
        $this->emit('videoViewed');

        // Videoansichten-Zähler um 1 erhöhen
        $this->video->update([
            'views' => $this->video->views + 1
        ]);
    }
}
