<?php

namespace App\Livewire\Comment;

use App\Models\Video;
use Livewire\Component;

class NewComment extends Component
{

    public $video;
    public $body = '';
    public $col;

    public function mount(Video $video , $col)
    {
        $this->video = $video;
        $col == 0 ? $this->col = null : $this->col = $col;
    }

    public function render()
    {
        return view('livewire.comment.new-comment')
            ->extends('layouts.app');

    }

    public function addComment()
    {

        //validaiton
        auth()->user()->comments()->create([
            'body' => $this->body,
            'video_id' => $this->video->id,
            'reply_id' => $this->col,
        ]);

        $this->body = "";
        // emit events to resfresh
    }


    public function createReply($commentId)
    {
        $this->validate([
            'body' => 'required|min:3'
        ]);

        $comment = $this->video->comments()->findOrFail($commentId);

        $comment->replies()->create([
            'body' => $this->body,
            'user_id' => auth()->user()->id
        ]);

        $this->body = '';
        $this->dispatch('commentAdded');
    }

    public function resetForm() {
        $this->body = "";
    }


}



