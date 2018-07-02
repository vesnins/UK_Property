@if(isset($admin_text))
  {!! $admin_text !!}
  {!! $current_url !!}
  <br/>
  <br/>
  <br/>
@endif

@include('emails.layouts.header')
@yield('content')
@include('emails.layouts.footer')