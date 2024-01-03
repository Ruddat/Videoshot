<?php

namespace App\Livewire\Video;

use App\Models\Like;
use App\Models\Video;
use App\Models\Dislike;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Voting extends Component
{

    public $video;

    public $likes;

    public $dislikes;

    public $dislikeActive;

    public $likeActive;

    protected $listeners = [
        'load_values' => 'loadValues'
    ];




    public function mount(Video $video)
    {
        $this->video = $video;

        $this->checkIfLiked();

        $this->checkIfDisliked();
    }

    public function checkIfLiked()
    {
        if ($this->video->doesUserLikedVideo(auth()->user())) {
            $this->likeActive = true;
        } else {
            $this->likeActive = false;
        }
    }

    public function checkIfDisliked()
    {
        if ($this->video->doesUserDislikedVideo(auth()->user())) {
            $this->dislikeActive = true;
        } else {
            $this->dislikeActive = false;
        }
    }

    public function render()
    {
        $this->likes = $this->video->likes()->count();
        $this->dislikes = $this->video->dislikes()->count();

        return view('livewire.video.voting')
            ->extends('layouts.app');

    }

    public function like()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
            }
     //   $this->video->like(auth()->user());

        if ($this->video->doesUserLikedVideo(auth()->user())) {
            //$this->video->removeLike(auth()->user());
            Like::where('user_id', auth()->user()->id)->where('video_id', $this->video->id)->delete();

            $this->likeActive = false;
         //   $this->dislikeActive = false;
        } else {
            $this->video->likes(auth()->user());
            $this->dislikeActive = false;
            $this->video->likes()->create([
                'user_id' => auth()->user()->id
            ]);

            $this->disableLike();
            $this->likeActive = true;
        }

        $this->dispatch('load_values');
    }

    public function dislike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
            }
        //   $this->video->dislike(auth()->user());

        if ($this->video->doesUserDislikedVideo(auth()->user())) {
            //$this->video->removeLike(auth()->user());
            Dislike::where('user_id', auth()->user()->id)->where('video_id', $this->video->id)->delete();

        //    $this->likeActive = false;
            $this->dislikeActive = false;
        } else {
            $this->video->dislikes(auth()->user());
            $this->likeActive = false;
            $this->video->dislikes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->disableDislike();
            $this->dislikeActive = true;
        }

      //  $this->dispatch('load_values');
    }

    public function disableDislike()
    {
        Like::where('user_id', auth()->user()->id)->where('video_id', $this->video->id)->delete();
        $this->dislikeActive = false;
    }

    public function disableLike()
    {
        Dislike::where('user_id', auth()->user()->id)->where('video_id', $this->video->id)->delete();
        $this->likeActive = false;
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
