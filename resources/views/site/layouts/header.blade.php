<!DOCTYPE html>
<html lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta content="width=device-width" name="viewport" />
  <meta name="author" content="{{ $meta['author'] ?? '' }}" />
  <title>{{ $meta['title'] ?? '' }}</title>
  <meta content="{{ $meta['description'] ?? '' }}" name="description">
  <meta content="{{ $meta['keywords'] ?? '' }}" name="keywords">
  <meta http-equiv="Last-Modified" content="{{ ($meta['created_at'] ?? '') ?? ($meta['updated_at'] ?? '') }}" />
  <link rel="icon" href="/images/favicon.png" sizes="32x32" />
  <link rel="stylesheet" href="/css/additional.css">
  <link rel="stylesheet" href="/css/libs/bootstrap-components.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
  <link rel="stylesheet" href="/css/libs/venobox.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/responsive.css">

  <meta property="og:title" content="{{ $meta['title'] ?? '' }}" />
  {{--<meta property="og:type" content="movie"/>--}}
  <meta property="og:url" content="http://greecobooking.niws.ru/villas/1" />
  <meta property="og:image" content="{{ $meta['og_image'] ?? '' }}" />
  {{--<meta property="og:site_name" content="IMDb"/>--}}
  {{--<meta property="fb:admins" content="USER_ID"/>--}}
  <meta property="og:description" content="{{ $meta['description'] ?? '' }}" />
</head>
<body>
<div class="wrapper">
  <div class="preloader">
    <div class="inner-box">
      <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
  </div>
  <header class="site-header">
    <div class="action-line">
      <div class="container-fluid">
        <div class="search-form-holder">
          <form role="search" class="search-form" action="/search">
            <input type="search" name="q" class="search-field" placeholder="@lang('main.i_m_searching_for') ..." />
            <input type="submit" class="search-submit" value="OK" />
          </form>

          <a href="javascript:void(0);" class="search-btn">
            <svg>
              <use xlink:href="/images/svg/sprite.svg#search-icon"></use>
            </svg>
            @lang('main.search')
          </a>
        </div>

        <a href="tel:{!! $langSt($params['phone_top']['key']) !!}" class="phone-link link">
          {!! $langSt($params['phone_top']['key']) !!}
        </a>

        <a href="#" class="modal-btn link" data-toggle="modal" data-target=".request-modal">
          @lang('main.request_a_call')
        </a>

        <select
          name="languages"
          class="languages" title=""
          onchange="document.location.href = document.location.href  + '/?setLang=' + this.value"
        >
          @if($lang === 'en')
            <option value="en">EN</option>
            <option value="ru">RU</option>
          @else
            <option value="ru">RU</option>
            <option value="en">EN</option>
          @endif
        </select>

        <a href="#" class="sound-switcher {{ env('AUDIO_AUTOPLAY') ? '' : 'muted' }}">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#speaker-icon"></use>
          </svg>
        </a>
      </div>
    </div>
    <div class="container-fluid navigation-area">
      <a class="logo" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 159 50">
          <defs>
            <style>.cls-4 {
                fill: #ba8558
              }</style>
            <linearGradient id="Безымянный_градиент" data-name="Безымянный градиент" x1="4.82" y1="24.8" x2="34.34"
              y2="44.08" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#ff9f00" />
              <stop offset="1" stop-color="#c41162" />
            </linearGradient>
            <linearGradient id="Безымянный_градиент_2" data-name="Безымянный градиент 2" x1="22.18" y1="37.69"
              x2="32.09" y2="21.34" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#c41162" />
              <stop offset="1" stop-color="#5a4b88" />
            </linearGradient>
          </defs>
          <path
            d="M35.4 6.2A20.58 20.58 0 0 0 6.3 35.3l14.5 14.5 14.5-14.5a20.55 20.55 0 0 0 .1-29.1zm-9.7 19.4a6.86 6.86 0 1 1 0-9.7 6.82 6.82 0 0 1 0 9.7z"
            fill="#5a4b88" />
          <path fill="url(#Безымянный_градиент)"
            d="M35.33 35.2L20.91 20.77l-.1-.1-.1.1L6.24 35.24 20.81 49.8l14.55-14.57-.03-.03z" />
          <path fill="url(#Безымянный_градиент_2)" d="M20.81 20.67V49.8l14.55-14.57-14.55-14.56z" />
          <path class="cls-4"
            d="M88.7 8.4a3 3 0 0 0-1.3-.9 5.62 5.62 0 0 0-2-.3h-2.8a1 1 0 0 0-1 1V20a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5v-4.3l2.4-.1a4.5 4.5 0 0 0 3.1-1.1 4.17 4.17 0 0 0 1.1-3.1 4.14 4.14 0 0 0-.2-1.6 3.09 3.09 0 0 0-.7-1.4zm-1.4 5.2a2.82 2.82 0 0 1-2.1.7H83V8.8h2.3a3 3 0 0 1 1.4.2 1.56 1.56 0 0 1 .8.6 3.55 3.55 0 0 1 .4.9c0 .3.1.7.1 1a2.92 2.92 0 0 1-.7 2.1zM69.6 13.3l4.1-5c.1-.2.2-.3.2-.5s0-.5-.2-.6a.52.52 0 0 0-.4-.2c-.2 0-.3.1-.4.1l-.3.3-4.8 5.9V7.8a.55.55 0 0 0-.2-.5.7.7 0 0 0-1.2.5V20a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5v-4.4l.9-1.1 4 5.9a.75.75 0 0 0 .7.4.85.85 0 0 0 .5-.3.76.76 0 0 0 .2-.5c0-.2 0-.3-.1-.4zM83.7 29.3c-.1 0-.2.1-.4.2a1.38 1.38 0 0 0-.3.4l-3.3 10.5-3.4-10.5c-.1-.2-.1-.3-.3-.4a.52.52 0 0 0-.4-.2.55.55 0 0 0-.5.2.76.76 0 0 0-.2.5v.2a.1.1 0 0 1 .1.1L78.7 42a1 1 0 0 0 1 1 .6.6 0 0 0 .6-.3 1.61 1.61 0 0 0 .4-.7l3.6-11.7c.1 0 .1 0 .1-.1V30a.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2zM96.8 36.6a3.11 3.11 0 0 0-.9-.7c-.4-.1-.7-.3-1.1-.4s-.7-.3-1.1-.4a4.18 4.18 0 0 1-1-.4.76.76 0 0 1-.4-.2q-.15 0-.3-.3a2.19 2.19 0 0 1-.3-.5c0-.2-.1-.5-.1-.8a3 3 0 0 1 .2-1 1.79 1.79 0 0 1 .5-.7c.3-.1.5-.2.8-.3s.6-.1.9-.1a2 2 0 0 1 .8.1c.2.1.4.1.6.2s.3.1.5.2.2.1.4.1.4 0 .5-.2a.76.76 0 0 0 .2-.5.75.75 0 0 0-.4-.7 2.47 2.47 0 0 0-.9-.4c-.4-.1-.7-.1-1.1-.2a3.44 3.44 0 0 0-.9-.1 3.71 3.71 0 0 0-2.8 1 3.47 3.47 0 0 0-1 2.7 4.44 4.44 0 0 0 .2 1.3 3.59 3.59 0 0 0 .7 1 3.11 3.11 0 0 0 .9.7 9.29 9.29 0 0 0 1 .5c.4.1.7.3 1.1.4a4.18 4.18 0 0 1 1 .4.76.76 0 0 1 .4.2 1.38 1.38 0 0 1 .3.4 2.19 2.19 0 0 1 .3.5c0 .3.1.5.1.8a5.79 5.79 0 0 1-.3 1.7 2.55 2.55 0 0 1-1.9.6 3.08 3.08 0 0 1-1-.1 1.88 1.88 0 0 1-.8-.2 1.42 1.42 0 0 1-.6-.2c-.1 0-.3-.1-.4-.1s-.4 0-.5.2a.76.76 0 0 0-.2.5.84.84 0 0 0 .4.7 3.92 3.92 0 0 0 .9.4 3.54 3.54 0 0 0 1.1.3 3.4 3.4 0 0 0 1 .1 4.15 4.15 0 0 0 1.6-.3 5.67 5.67 0 0 0 1.3-.8 3.81 3.81 0 0 0 .9-1.3 4.31 4.31 0 0 0 .3-1.7 3.18 3.18 0 0 0-.2-1.4 3.59 3.59 0 0 0-.7-1zM64 42l-3.5-11.6a1.61 1.61 0 0 0-.4-.7 1 1 0 0 0-1.4 0 4.88 4.88 0 0 0-.3.7l-3.7 11.7c-.1 0-.1 0-.1.1v.2a.68.68 0 0 0 .7.7c.1 0 .2-.1.4-.2a1.38 1.38 0 0 0 .3-.4l1.1-2.7h4.8l.8 2.6c0 .2.1.3.3.4a.52.52 0 0 0 .4.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5v-.2a.1.1 0 0 1-.1-.1zm-6.7-3.7l1.9-6.4 2 6.4zM72.9 30.9a3.81 3.81 0 0 0-1.6-1.1 6.25 6.25 0 0 0-2.5-.4h-2.1a1 1 0 0 0-1 1v11.4a1 1 0 0 0 1 1h2.1a6.25 6.25 0 0 0 2.5-.4 5 5 0 0 0 1.6-1.1 5.07 5.07 0 0 0 .9-1.6 5.82 5.82 0 0 0 .3-1.9v-3.6a5.66 5.66 0 0 0-.3-1.8 4.62 4.62 0 0 0-.9-1.5zm-.4 6.8a5.9 5.9 0 0 1-.2 1.4 2.22 2.22 0 0 1-.5 1.1 2 2 0 0 1-1 .8 4.15 4.15 0 0 1-1.6.3h-1.9V30.9h1.9a3.51 3.51 0 0 1 1.6.3 3.59 3.59 0 0 1 1 .7 2.38 2.38 0 0 1 .6 1.1 5.07 5.07 0 0 1 .2 1.3zM56.5 19.5a3 3 0 0 0 1.3.9 4.84 4.84 0 0 0 1.8.3 4.67 4.67 0 0 0 1.7-.3 3.81 3.81 0 0 0 1.3-.9 6.38 6.38 0 0 0 .8-1.4 4.84 4.84 0 0 0 .3-1.8l-.1-8.4a.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2.55.55 0 0 0-.5.2.76.76 0 0 0-.2.5v8.3a5.07 5.07 0 0 1-.2 1.3 3.13 3.13 0 0 1-.5 1 2.7 2.7 0 0 1-.8.7 4.3 4.3 0 0 1-1.2.2 2.53 2.53 0 0 1-2-.9 3.23 3.23 0 0 1-.7-2.2V7.9a.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2.55.55 0 0 0-.5.2.76.76 0 0 0-.2.5v8.4a4.84 4.84 0 0 0 .3 1.8 6.38 6.38 0 0 0 .8 1.4zM86.9 29.3a.55.55 0 0 0-.5.2.76.76 0 0 0-.2.5v12.3a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2c.2 0 .4 0 .5-.3a.76.76 0 0 0 .2-.5V30a.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2zM127.3 36.5a3.11 3.11 0 0 0-.9-.7c-.4-.1-.7-.3-1.1-.4s-.7-.3-1.1-.4a4.18 4.18 0 0 1-1-.4.76.76 0 0 1-.4-.2q-.15 0-.3-.3a2.19 2.19 0 0 1-.3-.5c0-.2-.1-.5-.1-.8a3 3 0 0 1 .2-1 1.79 1.79 0 0 1 .5-.7c.3-.1.5-.2.8-.3s.6-.1.9-.1a2 2 0 0 1 .8.1c.2.1.4.1.6.2s.3.1.5.2.2.1.4.1.4 0 .5-.2a.76.76 0 0 0 .2-.5.75.75 0 0 0-.4-.7 2.47 2.47 0 0 0-.9-.4c-.4-.1-.7-.1-1.1-.2a3.44 3.44 0 0 0-.9-.1 3.71 3.71 0 0 0-2.8 1 3.47 3.47 0 0 0-1 2.7 3.18 3.18 0 0 0 .2 1.4 3.59 3.59 0 0 0 .7 1 3.11 3.11 0 0 0 .9.7 9.29 9.29 0 0 0 1 .5c.4.1.7.3 1.1.4a4.18 4.18 0 0 1 1 .4.76.76 0 0 1 .4.2 1.38 1.38 0 0 1 .3.4 2.19 2.19 0 0 1 .3.5c0 .3.1.5.1.8a4.46 4.46 0 0 1-.3 1.6 2.55 2.55 0 0 1-1.9.6c-.4 0-.7-.1-1-.1a1.88 1.88 0 0 1-.8-.2 1.42 1.42 0 0 1-.6-.2c-.1 0-.3-.1-.4-.1s-.4 0-.5.2a.76.76 0 0 0-.2.5.84.84 0 0 0 .4.7 3.92 3.92 0 0 0 .9.4 3.54 3.54 0 0 0 1.1.3 3.4 3.4 0 0 0 1 .1 4.15 4.15 0 0 0 1.6-.3 5.67 5.67 0 0 0 1.3-.8 3.81 3.81 0 0 0 .9-1.3 4.31 4.31 0 0 0 .3-1.7 3.18 3.18 0 0 0-.2-1.4 3.59 3.59 0 0 0-.7-1zM136.4 14.8a4 4 0 0 0 2.1-1.2 4.15 4.15 0 0 0 .8-2.5 7.57 7.57 0 0 1 .1-1.5 4.73 4.73 0 0 0-.7-1.2 3.81 3.81 0 0 0-1.3-.9 6 6 0 0 0-2-.3h-3.3a.86.86 0 0 0-.6.3.91.91 0 0 0-.3.7v11.9a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5v-5.3h2.2l3.4 5.7a.55.55 0 0 0 .6.4.65.65 0 0 0 .5-.2.55.55 0 0 0 .3-.5.6.6 0 0 0-.1-.4zm-3.9-1.4V8.8h2.6a2.76 2.76 0 0 1 1.4.2 2.18 2.18 0 0 1 .8.5 3 3 0 0 1 .4.8c0 .3.1.5.1.8a2.57 2.57 0 0 1-.7 1.8 3.31 3.31 0 0 1-1.9.5zM128.4 19h-4.7v-4.5h4.1a.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2h-4.1V8.7h4.5c.2 0 .3-.1.5-.2a.76.76 0 0 0 .2-.5.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2h-5.1a.91.91 0 0 0-.7.3.86.86 0 0 0-.3.6v11.5a.84.84 0 0 0 .4.7 1.88 1.88 0 0 0 .8.2h5a.68.68 0 0 0 .7-.7c0-.2-.1-.4-.1-.7a.76.76 0 0 0-.5-.2zM147.8 7.3h-6.6c-.2 0-.3.1-.5.3s-.2.3-.2.5a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2h2.6V20a.55.55 0 0 0 .2.5.7.7 0 0 0 1.2-.5V8.7h2.6a.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5.55.55 0 0 0-.2-.5.76.76 0 0 0-.5-.2zM158.2 7.3a.76.76 0 0 0-.5-.2.37.37 0 0 0-.3.1c-.1 0-.2.1-.3.2l-2.9 6.2-2.9-6.2c-.1-.1-.2-.1-.3-.2a.37.37 0 0 0-.3-.1.68.68 0 0 0-.7.7.6.6 0 0 0 .1.4l3.4 7.2v4.7a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.46.46 0 0 0 .5-.3.76.76 0 0 0 .2-.5v-4.6l3.4-7.2a.76.76 0 0 0 .1-.4.55.55 0 0 0-.2-.5zM99.6 20.7a.55.55 0 0 0 .3-.5.6.6 0 0 0-.1-.4l-3.1-5a4 4 0 0 0 2.1-1.2 4.15 4.15 0 0 0 .8-2.5 7.52 7.52 0 0 1 0-1.5 4.73 4.73 0 0 0-.7-1.2 3.81 3.81 0 0 0-1.3-.9 6 6 0 0 0-2-.3h-3.3a.86.86 0 0 0-.6.3.91.91 0 0 0-.3.7v12a.55.55 0 0 0 .2.5.7.7 0 0 0 1.2-.5v-5.3H95l3.5 5.6a.55.55 0 0 0 .6.4.65.65 0 0 0 .5-.2zm-6.9-7.3V8.8h2.6a2.76 2.76 0 0 1 1.4.2 2.18 2.18 0 0 1 .8.5 3 3 0 0 1 .4.8c0 .3.1.5.1.8a2.57 2.57 0 0 1-.7 1.8 3.31 3.31 0 0 1-1.9.5zM109.2 8.6a7.1 7.1 0 0 0-1.4-1 5.2 5.2 0 0 0-4 0 3 3 0 0 0-1.4 1 3.61 3.61 0 0 0-.8 1.5 11.08 11.08 0 0 0-.2 1.9v4a5.82 5.82 0 0 0 .3 1.9 2.75 2.75 0 0 0 .8 1.5 7.1 7.1 0 0 0 1.4 1 3.81 3.81 0 0 0 1.9.4 4.06 4.06 0 0 0 1.9-.4 3.75 3.75 0 0 0 2.2-2.5 5.82 5.82 0 0 0 .3-1.9v-4a5.84 5.84 0 0 0-.2-1.9 5.3 5.3 0 0 0-.8-1.5zm-.7 7.4a4.37 4.37 0 0 1-.7 2.5 2.9 2.9 0 0 1-4.2 0 4.09 4.09 0 0 1-.7-2.5v-4a5.9 5.9 0 0 1 .2-1.4 4.67 4.67 0 0 1 .5-1 2.18 2.18 0 0 1 .9-.7 2.5 2.5 0 0 1 1.3-.3c.5 0 .9 0 1.1.3a3.51 3.51 0 0 1 .9.7 2.34 2.34 0 0 1 .5 1 5.9 5.9 0 0 1 .2 1.4zM119.4 8.4a3 3 0 0 0-1.3-.9 5.62 5.62 0 0 0-2-.3h-2.8a1 1 0 0 0-1 1V20a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5v-4.3l2.4-.1a4.5 4.5 0 0 0 3.1-1.1 4.17 4.17 0 0 0 1.1-3.1 4.14 4.14 0 0 0-.2-1.6 3.09 3.09 0 0 0-.7-1.4zm-1.4 5.2a2.82 2.82 0 0 1-2.1.7h-2.2l.1-5.5h2.2a3 3 0 0 1 1.4.2 1.56 1.56 0 0 1 .8.6 3.55 3.55 0 0 1 .4.9c0 .3.1.7.1 1a2.92 2.92 0 0 1-.7 2.1zM106.9 30.8a7.1 7.1 0 0 0-1.4-1 5.2 5.2 0 0 0-4 0 3 3 0 0 0-1.4 1 3.61 3.61 0 0 0-.8 1.5 11.08 11.08 0 0 0-.2 1.9v4a5.82 5.82 0 0 0 .3 1.9 2.75 2.75 0 0 0 .8 1.5 7.1 7.1 0 0 0 1.4 1 4.71 4.71 0 0 0 3.8 0 3.75 3.75 0 0 0 2.2-2.5 5.82 5.82 0 0 0 .3-1.9v-4a5.84 5.84 0 0 0-.2-1.9 5.3 5.3 0 0 0-.8-1.5zm-.7 7.4a4.37 4.37 0 0 1-.7 2.5 2.34 2.34 0 0 1-2.1.9 2.45 2.45 0 0 1-2.1-.9 4.09 4.09 0 0 1-.7-2.5v-4a5.9 5.9 0 0 1 .2-1.4 4.67 4.67 0 0 1 .5-1 2.18 2.18 0 0 1 .9-.7 2.5 2.5 0 0 1 1.3-.3c.6 0 1 .1 1.1.3a2.18 2.18 0 0 1 .9.7 2.34 2.34 0 0 1 .5 1 5.9 5.9 0 0 1 .2 1.4zM115.6 37a4 4 0 0 0 2.1-1.2 4.15 4.15 0 0 0 .8-2.5 3.81 3.81 0 0 1 .1-1.5 4.73 4.73 0 0 0-.7-1.2 3.81 3.81 0 0 0-1.3-.9 6 6 0 0 0-2-.3h-3.3a.86.86 0 0 0-.6.3.91.91 0 0 0-.3.7v11.9a.55.55 0 0 0 .2.5.76.76 0 0 0 .5.2.55.55 0 0 0 .5-.2.76.76 0 0 0 .2-.5V37h2.2l3.4 5.7a.55.55 0 0 0 .6.4.65.65 0 0 0 .5-.2.55.55 0 0 0 .3-.5.6.6 0 0 0-.1-.4zm-4-1.4V31h2.6a4.64 4.64 0 0 1 1.4.2 2.18 2.18 0 0 1 .8.5 3 3 0 0 1 .4.8c0 .3.1.5.1.8a2.41 2.41 0 0 1-.7 1.8 3.31 3.31 0 0 1-1.9.5z" />
        </svg>
      </a>
      <nav class="site-nav">
        <a href="javascript:void(0);" class="close-btn">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#close-icon"></use>
          </svg>
        </a>

        <form role="search" class="search-form" action="/search">
          <input type="search" name="q" class="search-field" placeholder="@lang('main.i_m_searching_for') ..." />
          <input type="submit" class="search-submit" value="OK" />
        </form>

        <ul class="menu">
          @foreach($menu as $val)
            @if(current($val)['cat'] === 0)
              @foreach($val as $v)
                @if(is_array($menu[$v['id']]))
                  <li class="parent-item">
                    <a
                      href="javascript:void(0)"
                      class="@if(($v['translation'] ?? $v['id']) === $segment1) active @endif"
                    >
                      {{ $langSt($v['name']) }}
                    </a>

                    <ul class="sub-menu">
                      @foreach($menu[$v['id']] as $vSub)
                        <li>
                          <a
                            href="/{{ $vSub['controller'] ? $vSub['controller'] : ($v['translation'] ?? $v['id']) }}/{{ $vSub['translation'] ?? $vSub['id'] }}"
                            class="@if(($vSub['translation'] ?? $vSub['id']) === $segment1) active @endif"
                          >
                            {{ $langSt($vSub['name']) }}
                          </a>
                        </li>
                      @endforeach
                    </ul>
                  </li>
                @else
                  <li>
                    <a
                      href="/{{ $v['controller'] ? $v['controller'] . '/' : '' }}{{ $v['translation'] ?? $v['id'] }}"
                      class="@if(($v['translation'] ?? $v['id']) === $segment1) active @endif"
                    >
                      {{ $langSt($v['name']) }}
                    </a>
                  </li>
                @endif
              @endforeach
            @endif
          @endforeach
        </ul>
      </nav>
      <div class="position-box">
        <a href="/selection-request" class="button light">@lang('main.selection_request')</a>

        <a href="/favorite" class="wish-list" style="display: none">
          <svg>
            <use xlink:href="/images/svg/sprite.svg#heart-icon"></use>
          </svg>

          <span class="qty"></span>
        </a>

        <button class="menu-btn"><span></span></button>
      </div>
    </div>
  </header>