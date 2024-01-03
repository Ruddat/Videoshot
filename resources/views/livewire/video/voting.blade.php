<div>
    <div class="d-flex">
        <div class="d-flex align-items-center">
            <span class="material-icons @if ($likeActive) text-primary @else text-secondary @endif"
                style="font-size: 2rem; color: #065fd4; cursor: pointer;" wire:click="like">thumb_up</span>
            <span class="mx-2">{{ $likes }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span class="material-icons @if ($dislikeActive) text-primary @else text-secondary @endif"
                style="font-size: 2rem; color: #065fd4; cursor: pointer;" wire:click="dislike">thumb_down</span>
            <span class="mx-2">{{ $dislikes }}

            </span>
        </div>

    </div>
</div>
