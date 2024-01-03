<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


@include('includes.head')

<body id="page-top">


    <nav class="navbar navbar-expand navbar-light bg-white static-top osahan-nav sticky-top">
        &nbsp;&nbsp;
        <button class="btn btn-link btn-sm text-secondary order-1 order-sm-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button> &nbsp;&nbsp;
        <a class="navbar-brand mr-1" href="{{ url('/') }}"><img class="img-fluid"
                alt="{{ config('app.name', 'Laravel') }}" src="{{ asset('img/logo.png') }}"></a>

                    <select class="form-select change_lang">
                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>France</option>
                        <option value="de" {{ session()->get('locale') == 'de' ? 'selected' : '' }}>Germany</option>
                        <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Spanish</option>
                    </select>


        {{-- Navbar Search --}}
        {{-- search --}}
        <form action="/search" method="GET"
            class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-5 my-2 my-md-0 osahan-navbar-search ">
            <div class="input-group">
                <input type="text" name="query" id="query" class="form-control" placeholder="Search for...">
                <div class="input-group-append">
                    <button class="btn btn-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        {{-- search --}}

        <!-- Navbar -->

        <ul class="navbar-nav ml-auto ml-md-0 osahan-right-navbar">


            <livewire:bookmarks-component :wire:key="'bookmarks-component-'.time()" />






            @auth
                <li class="nav-item mx-1">
                    <a class="nav-link" href="{{ route('video.create', ['channel' => Auth::user()->channel]) }}">
                        <i class="fas fa-plus-circle fa-fw"></i>
                        Upload Video
                    </a>
                </li>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                        @foreach (auth()->user()->unreadNotifications as $notification)
                            <div class="dropdown-item">
                                <a href="{{ $notification->data['video_link'] }}">
                                    <i class="fas fa-fw fa-video"></i> &nbsp; Video Anzeigen
                                </a>
                            </div>
                            <div class="dropdown-item">
                                <a class="dropdown-item" href="{{ route('notification.read', $notification->id) }}">
                                    <i class="fas fa-fw fa-edit "></i> &nbsp; {{ $notification->data['message'] }}
                                </a>
                            </div>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('notifications.markAllAsRead') }}">
                            <i class="fas fa-fw fa-star"></i> &nbsp; Alles als gelesen markieren
                        </a>
                    </div>




                </li>


                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <span class="badge badge-success">7</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-edit "></i> &nbsp; Action</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-headphones-alt "></i> &nbsp; Another
                            action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star "></i> &nbsp; Something else
                            here</a>
                    </div>
                </li>
            @endauth

            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown no-arrow osahan-right-navbar-user">
                    <a class="nav-link dropdown-toggle user-dropdown-link" href="#" id="userDropdown"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (Auth::user()->avatar)
                        <img alt="Avatar" src="{{ asset(Auth::user()->avatar) }}">
                    @elseif ($channelImage)
                        <img alt="Channel Picture" src="{{ asset($channelImage) }}">
                    @else
                        <img alt="Avatar" src="{{ asset('img/user.png') }}">
                    @endif
                    {{ Auth::user()->name }}
                </a>



                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('account') }}"><i class="fas fa-fw fa-user-circle"></i>
                            &nbsp; My Account</a>
                        <a class="dropdown-item" href="subscriptions.html"><i class="fas fa-fw fa-video"></i> &nbsp;
                            Subscriptions</a>
                        <a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-fw fa-cog"></i> &nbsp;
                            Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i
                                class="fas fa-fw fa-sign-out-alt"></i> &nbsp; Logout</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal"
                            data-target="#logoutModal"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i
                                class="fas fa-fw fa-sign-out-alt"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest

        </ul>
    </nav>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('channel.index', ['channel' => Auth::user()->channel]) }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Channels</span>
                    </a>
                </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-user-alt"></i>
                    <span>My Channel</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="video-page.html">
                    <i class="fas fa-fw fa-video"></i>
                    <span>Video Page</span>
                </a>
            </li>
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('video.create', ['channel' => Auth::user()->channel]) }}">
                        <i class="fas fa-fw fa-cloud-upload-alt"></i>
                        <span>Upload Video</span>
                    </a>
                </li>
            @endauth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div class="dropdown-menu">
                    <h6 class="dropdown-header">Login Screens:</h6>
                    <a class="dropdown-item" href="login.html">Login</a>
                    <a class="dropdown-item" href="register.html">Register</a>
                    <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header">Other Pages:</h6>
                    <a class="dropdown-item" href="404.html">404 Page</a>
                    <a class="dropdown-item" href="blank.html">Blank Page</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('history') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History Page</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="categories.html" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-list-alt"></i>
                    <span>Categories</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="categories.html">Movie</a>
                    <a class="dropdown-item" href="categories.html">Music</a>
                    <a class="dropdown-item" href="categories.html">Television</a>
                </div>
            </li>
            <li class="nav-item channel-sidebar-list">
                <h6>SUBSCRIPTIONS</h6>
                <ul>
                    <li>
                        <a href="subscriptions.html">
                            <img class="img-fluid" alt="" src="{{ asset('img/s1.png') }}"> Your Life
                        </a>
                    </li>
                    <li>
                        <a href="subscriptions.html">
                            <img class="img-fluid" alt="" src="img/s2.png"> Unboxing <span
                                class="badge badge-warning">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="subscriptions.html">
                            <img class="img-fluid" alt="" src="img/s3.png"> Product / Service
                        </a>
                    </li>
                    <li>
                        <a href="subscriptions.html">
                            <img class="img-fluid" alt="" src="img/s4.png"> Gaming
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        {!! Toastr::message() !!}
        <div id="content-wrapper">



            @yield('content')

            <!-- /.container-fluid -->

            <!-- Sticky Footer -->

        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @stack('scripts')
    @livewireScripts
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>



<script type="text/javascript">
    var url = "{{ route('change.lang') }}";
    $(".change_lang").change(function() {
        window.location.href = url + "?lang=" + $(this).val();
    });



</script>
</body>




</html>
