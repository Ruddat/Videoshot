<div>
    <!-- Stern zum Markieren -->
    <a href="#" wire:click.prevent="addToBookmarks" wire:loading.attr="disabled">
        @if (!$bookmarked)
        <i class="fas fa-check-circle text-danger"> Hinzufuegen</i>

            ☆ <!-- Wenn das Video noch nicht in den Lesezeichen ist, zeige den leeren Stern an -->
        @else

        <i class="fas fa-check-circle text-success"></i>
            ★ <!-- Wenn das Video bereits in den Lesezeichen ist, zeige den gefüllten Stern an -->
        @endif
    </a>

    <!-- Feedback nach dem Hinzufügen -->
    @if ($bookmarked)
        <span id="bookmarkFeedback">Video im Merkzettel gespeichert!</span>
    @elseif($errorMessage)
        <span id="bookmarkError">{{ $errorMessage }}</span>
    @endif
</div>
