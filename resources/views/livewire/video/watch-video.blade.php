@push('custom-css')
<link href="https://vjs.zencdn.net/8.6.1/video-js.css" rel="stylesheet" />

<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
<!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@endpush
<div class="container-fluid pb-0">
    <div class="video-block section-padding">
       <div class="row">
          <div class="col-md-8">
             <div class="single-video-left">
                <div class="single-video">
                    <div style="width:100% ; height: 400px ;">


                        <video controls autoplay preload="auto" id="my-video" wire:ignore
                            class="video-js vjs-fill vjs-styles=defaults vjs-big-play-centered"
                            poster="{{ asset('videos' . $video->thumbnail_image) }}"
                            data-setup="{}">
                            <source src="{{ asset('videos/' . $video->uid . '/' . $video->processed_file) }}"
                                type="application/x-mpegURL" />
                            <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a
                                web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5
                                    video</a>
                            </p>
                        </video>
                    </div>

                </div>
                <div class="single-video-title box mb-3">
                   <h2><a href="#">{{ $video->title }}</a></h2>
                   <p class="mb-0"><i class="fas fa-eye"></i> {{ $video->views }} {{ Str::plural('view', $video->views) }}</p>
                   <livewire:video-component :videoUrl="$video->uid" :videoId="$video->id" />

                </div>
                <div class="single-video-author box mb-3">


                   <div class="float-right"><button  class="btn btn-danger" type="button">Subscribe <strong>{{ $video->channel->subscribers() }}</strong></button> <button class="btn btn btn-outline-danger" type="button"><i class="fas fa-bell"></i></button></div>
                   <img class="img-fluid" src="{{ asset('/images/' .  $video->channel->image)}}" alt="">
                   <p><a href="#"><strong>{{ $video->channel->name }} Channel</strong></a> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></p>
                   <small>Published on {{ $video->uploaded_date }}</small>
                </div>




                <div class="single-video-info-content box mb-3">
                   <h6>Cast:</h6>
                   <p>Nathan Drake , Victor Sullivan , Sam Drake , Elena Fisher</p>
                   <h6>Category :</h6>
                   <p>Gaming , PS4 Exclusive , Gameplay , 1080p</p>
                   <h6>About :</h6>
                   <p>{{ $video->description }} </p>
                   <h6>Tags :</h6>
                   <p class="tags mb-0">
                      <span><a href="#">Uncharted 4</a></span>
                      <span><a href="#">Playstation 4</a></span>
                      <span><a href="#">Gameplay</a></span>
                      <span><a href="#">1080P</a></span>
                      <span><a href="#">ps4Share</a></span>
                      <span><a href="#">+ 6</a></span>
                   </p>
                </div>





             </div>
          </div>
          <div class="col-md-4">
             <div class="single-video-right">
                <div class="row">
                   <div class="col-md-12">
                      <div class="adblock">
                         <div class="img">
                            Google AdSense<br>
                            336 x 280
                         </div>
                      </div>
                      <div class="main-title">
                         <div class="btn-group float-right right-action">
                            <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                               <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                            </div>
                         </div>
                         <h6>Up Next</h6>
                      </div>
                   </div>
                   <div class="col-md-12">

                    @foreach($nextVideos as $nextVideo)
                    <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="{{ route('watch.video', $nextVideo)}}"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="{{ asset('videos' . $nextVideo->thumbnail_image) }}" alt=""></a>
                            <div class="time">{{ \App\Helpers\VideoHelper::formatDuration($nextVideo->duration) }}</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="{{ route('watch.video', $nextVideo)}}">{{ $nextVideo->title }}</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                                {{ $nextVideo->views }} &nbsp;<i class="fas fa-calendar-alt"></i> {{ $nextVideo->created_at->diffForHumans() }}
                            </div>
                         </div>
                      </div>
                      @endforeach




                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v3.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">Culpa qui officia deserunt mollit anim</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v4.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">Deserunt mollit anim id est laborum.</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v5.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">Exercitation ullamco laboris nisi ut.</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v6.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">There are many variations of passages of Lorem</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                      <div class="adblock mt-0">
                         <div class="img">
                            Google AdSense<br>
                            336 x 280
                         </div>
                      </div>
                      <div class="video-card video-card-list">
                         <div class="video-card-image">
                            <a class="play-icon" href="#"><i class="fas fa-play-circle"></i></a>
                            <a href="#"><img class="img-fluid" src="img/v2.png" alt=""></a>
                            <div class="time">3:50</div>
                         </div>
                         <div class="video-card-body">
                            <div class="btn-group float-right right-action">
                               <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                  <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                               </div>
                            </div>
                            <div class="video-title">
                               <a href="#">Duis aute irure dolor in reprehenderit in.</a>
                            </div>
                            <div class="video-page text-success">
                               Education  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                            </div>
                            <div class="video-view">
                               1.8M views &nbsp;<i class="fas fa-calendar-alt"></i> 11 Months ago
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 @push('scripts')
 <script src="https://vjs.zencdn.net/8.6.1/video.min.js"></script>
 <script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('my-video');
    const videoId = {{ $video->id }};
    let countingStarted = false;

    video.addEventListener('timeupdate', function() {
        if (!countingStarted && this.currentTime > 3) {
            countingStarted = true;
            axios.post('/update-views', { video_id: videoId })
                .then(function(response) {
                    console.log('Views updated successfully after 3 seconds!');
                })
                .catch(function(error) {
                    console.error('Error updating views:', error);
                });
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Erfasse die aktuelle Browser-URL
    const currentUrl = window.location.href;

    // Sende die URL an die Livewire-Komponente
    Livewire.emit('currentUrlChanged', currentUrl);
});

  </script>
@endpush
