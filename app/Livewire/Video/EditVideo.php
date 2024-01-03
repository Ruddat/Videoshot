<?php

namespace App\Livewire\Video;

use App\Models\Video;
use App\Models\Channel;
use Livewire\Component;

class EditVideo extends Component
{

    public Channel $channel;

    public Video $video;

    protected $rules = [
        'video.title' => 'required|max:255',
        'video.description' => 'nullable|max:1000',
        'video.visibility' => 'required|in:private,unlisted,public',
    ];

    public function mount(Channel $channel, Video $video)
    {
        $this->channel = $channel;
        $this->video = $video;
    }

    public function render()
    {
        return view('livewire.video.edit-video')
        ->extends('layouts.app');
    }

    public function update()
    {

        $this->validate();

        $this->video->save();

        session()->flash('success', 'Video updated successfully');

        return redirect()->route('video.all', [

        'channel' => $this->channel,
        'video' => $this->video,

        ]);

    }
}
