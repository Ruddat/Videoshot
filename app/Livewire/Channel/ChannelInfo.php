<?php

namespace App\Livewire\Channel;

use App\Models\Channel;
use Livewire\Component;
use App\Models\Subscription;

class ChannelInfo extends Component
{

    public $channel;

    public $userSubscribed = false;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
        if (auth()->check()) {

            if (auth()->user()->isSubscribedTo($this->channel)) {

                $this->userSubscribed = true;
               }


        }
    }

    public function render()
    {
        return view('livewire.channel.channel-info')
            ->extends('layouts.app');
    }

    public function toggleSubscription()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isSubscribedTo($this->channel)) {

            Subscription::where('user_id', auth()->id())->where('channel_id', $this->channel->id)->delete();

            $this->userSubscribed = false;

        } else {

            Subscription::create([
                'user_id' => auth()->id(),
                'channel_id' => $this->channel->id
            ]);

            $this->userSubscribed = true;
        }
    }

}
