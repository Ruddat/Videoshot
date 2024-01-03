<!-- resources/views/errors/404.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-md-8 mx-auto text-center  pt-4 pb-5">
          <h1><img alt="404" src="{{ asset('img/404.png') }}" class="img-fluid"></h1>
          <h1>{{ Str::limit(GoogleTranslate::trans('Sorry! Page not found.', app()->getLocale()), 50) }}</h1>
          <p class="land">{{ Str::limit(GoogleTranslate::trans('Unfortunately the page you are looking for has been moved or deleted.', app()->getLocale()), 150) }}</p>
          <div class="mt-5">
             <a class="btn btn-outline-primary" href="{{ url('/') }}"><i class="mdi mdi-home"></i>{{ Str::limit(GoogleTranslate::trans('GO TO HOME PAGE', app()->getLocale()), 50) }}</a>
          </div>
       </div>
    </div>
 </div>
@endsection
