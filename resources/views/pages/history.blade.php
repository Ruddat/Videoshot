@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="video-block section-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <div class="btn-group float-right right-action">
                            <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top
                                    Rated</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp;
                                    Viewed</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp;
                                    Close</a>
                            </div>
                        </div>
                        <h6>Watch History</h6>
                    </div>
                </div>


                @php
                $viewedVideoIds = [];
            @endphp

                @foreach ($recentlyViewedVideos as $view)
                @if (!in_array($view->video->id, $viewedVideoIds))
                @php
                    $viewedVideoIds[] = $view->video->id;
                @endphp

                       <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="video-card history-video">
                            <div class="video-card-image">
                                <a class="video-close" href="{{ route('remove.video', $view->video_id) }}" class="remove-video"><i
                                        class="fas fa-times-circle"></i></a>
                                <a class="play-icon" href="{{ route('watch.video', $view->video) }}">
                                    <i class="fas fa-play-circle"></i>
                                </a>

                                <a href="#"><img class="img-fluid" src="{{ asset($view->video->thumbnail) }}"
                                        alt=""></a>
                                <div class="time">{{ \App\Helpers\VideoHelper::formatDuration($view->video->duration) }}</div>
                            </div>


                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100">1:40</div>
                            </div>


                            <div class="video-card-body">
                                <div class="video-title">
                                    <a href="#">{{ $view->video->title }}</a>
                                </div>
                                <div class="video-page text-success">
                                    @if ($view->video->channel)
                                        {{ $view->video->channel->name }}
                                    @else
                                        No Channel Available
                                    @endif
                                    <a title="" data-placement="top" data-toggle="tooltip" href="#"
                                        data-original-title="Verified">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </a>
                                </div>
                                <div class="video-view">
                                    {{ $view->video->views }} views &nbsp;<i class="fas fa-calendar-alt"></i>
                                    {{ $view->video->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div>
        <!-- Anzeige der Paginierungslinks -->
        {{ $paginatedVideos->links('pagination::bootstrap-5') }}
        </div>
    </div>

    @include('includes.footer-01')
@endsection
