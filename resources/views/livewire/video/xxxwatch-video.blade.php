<div>
    @push('custom-css')
        <link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />
    @endpush

    <div class="container-fluid" wire:ignore>
        <div class="row">
            <div class="col-md-12">
                <video id="my-video" class="video-js vjs-default-skin" controls preload="auto"
                    poster="{{ asset('videos' . $video->thumbnail_image) }}"

                    data-setup='{ }'>
                    <source src="{{ asset('videos/' . $video->uid . '/' . $video->processed_file) }}"
                        type="application/x-mpegURL"/>


                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>





            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-item-center">
                            <div class="col-md-8">
                                <h4>{{ $video->title }}</h4>
                                <p>{{ $video->views }} {{ Str::plural('view', $video->views) }}
                                    {{ $video->uploaded_date }}</p>
                                <p>{{ $video->description }}</p>
                            </div>
                            <hr>
                            <div class="col-md-4">
                                <livewire:video.voting :video="$video" />

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center align-items-center g-2">
                    <div class="col-md-12">
                        <livewire:channel.channel-info :channel="$video->channel" />
                    </div>

                </div>
<hr>
                <div class="row">
                    <div class="col-md-12">

                        <h4>{{$video->AllCommentsCount()}} Comment</h4>
                        @auth
                        <div class="my-2">
                            <livewire:comment.new-comment :video="$video" :col=0 :key="$video->id " />
                        </div>
                        @endauth

                        <livewire:comment.all-comments :video="$video" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script>
    <script src="{{ asset('js/videojs-http-streaming.js') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            var player = videojs('my-video')
        player.on('timeupdate', function () {
            if (this.currentTime() > 3)   {
                this.off('timeupdate');
                @this.call('countView');

            }
            });
        });
        player.qualityLevels();

     </script>
@endpush
</div>
