<div>
    @include('includes.recursive', ['comments' => $video->comments()->get()])
</div>
