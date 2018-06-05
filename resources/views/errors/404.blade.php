@extends('site.layouts.default')

@section('content')
  <main class="main error-page-content" style="background-image: url('/images/banners/img_8.jpg')">
    <div class="inner-box">
      <div class="container text-center">
        <h1 class="invisible">404</h1>
        <h2>@lang('main.there_is_no_such_page')</h2>
        <a href="/" class="button">@lang('main.to_main')</a>
      </div>
    </div>
  </main>
@endsection
