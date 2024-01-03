<?php

namespace App\Livewire\Video;

use App\Models\Video;
use App\Models\Channel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AllVideo extends Component
{

    use WithPagination;
    use AuthorizesRequests;


    protected $paginationTheme = 'bootstrap';

    public $channel;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }


    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', auth()->user()->channel->videos()->orderBy('created_at', 'desc')->paginate(12))
            ->extends('layouts.app');
    }

    public function delete(Video $video)
    {

        $this->authorize('delete', $video);

    // delete folder

    $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

    if ($deleted) {
        $video->delete();
    }

    session()->flash('success', 'Video deleted successfully');
    return redirect()->back();



     //   $video = auth()->user()->channel->videos()->findOrFail($videoId);

    //    $this->authorize('delete', $video);

    //    $video->delete();

    }
}
