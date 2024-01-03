<div>

<div class="d-flex align-items-center justify-content-between">

    <div class="d-flex align-items-center">

        <img src="{{ asset('/images/' . $channel->image) }}" class="rounded-circle">
        <div class="margin-right 2">
            <h4>{{ $channel->name }}</h4>
            <p class="text-sm">{{ $channel->subscribers() }} subscribers</p>

        </div>
    </div>

    <div>
        <button wire:click.prevent="toggleSubscription"

            type="button" class=" text-uppercase {{ $userSubscribed ? 'btn btn-primary btn-lg' : 'btn btn-secondary btn-lg' }}">

            {{ $userSubscribed ? 'Subscribed' : 'Subscribe' }}
        </button>
        </div>


</div>

</div>
