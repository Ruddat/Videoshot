
<div class="container-fluid pb-0">
    <!-- ... -->
    <div class="row">
        @foreach ($videos as $video)
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="video-card">
                    <div class="video-card-image">
                        <!-- Hier wird das Thumbnail des Videos eingefügt -->
                        <a class="play-icon" href="{{ route('watch.video', $video) }}"><i class="fas fa-play-circle"></i></a>
                        <a href="{{ route('watch.video', $video) }}"><img class="img-fluid" src="@videoThumbnail($video->thumbnail_image)" alt=""></a>
                        <div class="time">{{ \App\Helpers\VideoHelper::formatDuration($video->duration) }}</div>
                    </div>
                    <div class="video-card-body">
                        <div class="video-title">
                            <!-- Hier wird der Titel des Videos eingefügt -->
                            <a href="{{ route('watch.video', $video) }}">{{ $video->title }}</a>
                        </div>
                        <div class="video-page">
                            <!-- Hier wird die Beschreibung des Videos eingefügt -->
                            {{ $video->description }}
                        </div>
                        <div class="video-view">
                            <!-- Hier wird das Datum des Videos eingefügt -->
                            {{ $video->created_at->diffForHumans() }}
                        </div>
                        <!-- Edit- und Delete-Buttons -->
                        @if (auth()->user()->owns($video))
                            <div class="video-actions">
                                <a href="{{ route('video.edit', ['channel' => auth()->user()->channel, 'video' => $video->uid]) }}"
                                    class="btn btn-outline-light">Edit</a>
                                <a wire:click.prevent="delete('{{ $video->uid }}')"
                                    class="btn btn-outline-danger">Delete</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="row">
        <div class="col-md-12">
            {{ $videos->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
    <!-- ... -->
</div>
