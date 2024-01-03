<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters">
               <div class="col-md-5 p-5 bg-white full-height">
                  <div class="login-main-left">
                     <div class="text-center mb-5 login-main-left-header pt-4">
                        <a href="{{ url('/') }}">
                        <img src="img/favicon.png" class="img-fluid" alt="LOGO"> </a>
                        <h5 class="mt-3 mb-3">{{ GoogleTranslate::trans('Welcome to Vidoe', app()->getLocale()) }}</h5>
                        <p>{{ GoogleTranslate::trans('It is a long established fact that a reader', app()->getLocale()) }}
                            <br>{{ GoogleTranslate::trans('will be distracted by the readable.', app()->getLocale()) }}</p>
                     </div>


                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                           <label for="email">{{ __('Email Address') }}</label>
                           <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter E-Mail">
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror

                        </div>
                        <div class="form-group">
                           <label for="password">{{ __('Password') }}</label>
                           <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror

                        </div>

                        <div class="mt-4">
                            <div class="row">
                               <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            </div>
                         </div>

                        <div class="mt-4">
                           <div class="row">
                              <div class="col-12">
                                 <button type="submit" class="btn btn-outline-primary btn-block btn-lg">{{ __('Login') }}</button>
                              </div>
                           </div>
                        </div>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif


                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray">{{ GoogleTranslate::trans('Don’t have an account?', app()->getLocale()) }} <a href="{{ route('register') }}">{{ __('Register') }}</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="login-main-right bg-white p-5 mt-5 mb-5">
                     <div class="owl-carousel owl-carousel-login">
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">​Watch videos offline</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Download videos effortlessly</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="img/login.png" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Create GIFs</h5>
                              <p class="mb-4">when an unknown printer took a galley of type and scrambled<br> it to make a type specimen book. It has survived not <br>only five centuries</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="js/custom.js"></script>
   </body>
</html>
