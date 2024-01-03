<?php

namespace App\Livewire\Video;

use App\Models\Video;
use App\Models\Channel;
use Livewire\Component;
use Livewire\WithFileUploads;
use Brian2694\Toastr\Facades\Toastr;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Notifications\VideoProcessedNotification;

class CreateVideo extends Component
{

    use WithFileUploads;

    public Channel $channel;

    public Video $video;

    public $videoFile;

    protected $rules = [
        'video.title' => 'required|max:255',
        'video.description' => 'nullable|max:1000',
        'video.visibility' => 'required|in:private,unlisted,public',
        'videoFile' => 'required|mimes:mp4|max:10240000'
    ];

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
        $this->video = new Video();
    }

    public function render()
    {

        return view('livewire.video.create-video')
        ->extends('layouts.app');
    }

    public function fileComplete()
    {

     //   $this->validate();

     // save the file to videos-temp folder
     $path = $this->videoFile->store('videos-temp');

     // create a new video record in the database
        $this->video = $this->channel->videos()->create([
            'title' => 'untitled',
            'description' => 'none',
            'visibility' => 'private',
            'uid' => uniqid(true),

            'path' => explode('/', $path)[1],

        ]);

        // dispatch a job to handle the video conversion

    CreateThumbnailFromVideo::dispatch($this->video);

    ConvertVideoForStreaming::dispatch($this->video, auth()->id());

    Toastr::success('Messages in here', 'Title', ["positionClass" => "toast-top-center"]);

    $this->dispatch('showSuccessToast');

        // redirect to the edit video page
    return redirect()->route('video.edit', [

    'channel' => $this->channel,
    'video' => $this->video,

    ]);

    }

    public function upload()
    {
        $this->validate([
            'video.title' => 'required|max:255',
            'video.description' => 'nullable|max:1000',
            'video.visibility' => 'required|in:private,unlisted,public',
            'videoFile' => 'required|mimes:mp4|max:102400'
        ]);

        $this->video->channel()->associate($this->channel);
        $this->video->save();

        return redirect()->route('video.show', $this->video);
    }
}
